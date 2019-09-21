<template>
  <q-page>
    <q-stepper
      style="border:0;box-shadow:none;"
      :class="{'bg-grey-9':$store.state.DB.dark}"
      v-model="step"
      :dark="$store.state.DB.dark"
      :active-color="'green'"
      :done-color="'green'"
      :color="$store.state.DB.dark?'grey-10':'green'"
    >

      <q-step
        :name="1"
        title="Select a Skin"
        icon="photo"
        :done="step > 1"
      >
        <div class="row" style="max-height:calc(100vh - 272px - 32px + 42px + 50px);overflow-y:auto;">
          <div class="col-12 col-sm-6 row" style="padding:8px">
            <q-card class="col-12" :class="{'bg-grey-10':$store.state.DB.dark&&'template:minizee'!=skin,'bg-grey-8':'template:minizee'==skin&&$store.state.DB.dark,'bg-green-1':'template:minizee'==skin&&!$store.state.DB.dark}" v-ripple @click="skin='template:minizee';">
              <q-card-section style="padding:8px;" class="text-center">
                <img style="width:auto;max-height:300px;margin-bottom:-6px;max-width:100%;" src="/statics/butterfly.png"/>
                <div style="font-weight:bold;">
                  MiniZee
                </div>
                <div :class="$store.state.DB.dark?'text-grey-5':'text-grey-8'" style="font-size:0.8em;">Added: 20/09/2019</div>
              </q-card-section>
            </q-card>
          </div>
          <div class="col-12 col-sm-6 row" style="padding:8px">
            <q-card class="col-12" :class="{'bg-grey-10':$store.state.DB.dark&&'template:rum'!=skin,'bg-grey-8':'template:rum'==skin&&$store.state.DB.dark,'bg-green-1':'template:rum'==skin&&!$store.state.DB.dark}" v-ripple @click="skin='template:rum';">
              <q-card-section style="padding:8px;" class="text-center">
                <img style="width:auto;max-height:300px;margin-bottom:-6px;max-width:100%;" src="/statics/negs.png"/>
                <div style="font-weight:bold;">
                  Side
                </div>
                <div :class="$store.state.DB.dark?'text-grey-5':'text-grey-8'" style="font-size:0.8em;">Added: 20/09/2019</div>
              </q-card-section>
            </q-card>
          </div>
        </div>

        <q-stepper-navigation>
          <q-btn :disable="!skin" @click="step = 2" color="green" label="Continue" />
          <q-btn flat to="/" color="green" label="Back" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>

      <q-step
        :name="2"
        title="Customize"
        icon="format_paint"
        :done="step > 2"
      >
        <QRSkin :skin="`${skin}|${icon}`"/>
        <q-input :dark="$store.state.DB.dark" label="Image URL" color="green" outlined dense v-model="icon"/>

        <q-stepper-navigation>
          <q-btn :disable="!skin" @click="step = 3" color="green" label="Continue" />
          <q-btn flat @click="step = 1" color="green" label="Back" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>

      <q-step
        :name="3"
        title="Insert Munzees"
        icon="list"
      >
        <QRSkin :skin="`${skin}|${icon}`" style="height:300px;"/>

        <q-input
          v-model="munzees"
          label="Munzee QR URLs"
          stack-label
          color="green"
          outlined
          :dark="$store.state.DB.dark"
          dense
          autogrow
        />

        <div class="text-red" v-if="munzees.split('\n').findIndex(i=>i&&!i.match(/http(?:s)?:\/\/(?:www\.)?munzee.com\/m\/[^/]+\/\d+\/[A-z0-9]{6}(?:\/)?/))!=-1">
          Invalid Munzee on Line {{munzees.split('\n').findIndex(i=>i&&!i.match(/http(?:s)?:\/\/(?:www\.)?munzee.com\/m\/[^/]+\/\d+\/[A-z0-9]{6}(?:\/)?/))+1}}
        </div>

        <q-stepper-navigation>
          <q-btn :to="url" :disable="munzees.split('\n').filter(i=>i).length==0||munzees.split('\n').findIndex(i=>i&&!i.match(/http(?:s)?:\/\/(?:www\.)?munzee.com\/m\/[^/]+\/\d+\/[A-z0-9]{6}(?:\/)?/))!=-1" color="green" label="Generate" />
          <q-btn flat @click="step = 2" color="green" label="Back" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>
    </q-stepper>
  </q-page>
</template>

<script>
import QRSkin from "components/QRSkin"
import lf from "localforage"

export default {
  data() {
    return {
      step: 1,
      skin: '',
      munzees: '',
      icon: 'https://munzee.global.ssl.fastly.net/images/pins/munzee.png'
    }
  },
  computed: {
    url () {
      return `/generate/${encodeURIComponent(`${this.skin}|${this.icon}`)}/${this.munzees.split('\n').filter(i=>i).map(i=>(i.match(/http(?:s)?:\/\/(?:www\.)?munzee.com\/m\/([^/]+)\/(\d+)\/([A-z0-9]{6})(?:\/)?/)||[]).slice(1, 4).join('|')).join(',')}`
    },
    favs () {
      return this.$store.state.DB.favs||[];
    }
  },
  methods: {
    addFav (id) {
      this.$store.commit('DB/addFav', id);
    },
    async getCustomSkins () {
      if (!this.customSkinsLoading) {
        this.customSkinsLoading = true;
        let _this = this;
        var keys = (await lf.keys()).filter(i=>i.startsWith('custom:'));
        this.klen = keys.length;
        for (var i = 0; i < keys.length; i++) {
          let k = keys[i];
          lf.getItem(k).then((data)=>{ _this.customSkins.push(data) })
        }
      }
    },
    async del (val) {
      var x = confirm('Are you sure you want to delete this skin?')
      if (x) {
        lf.removeItem(val);
        this.customSkins = [];
        this.customSkinsLoading = false;
        this.klen = 1;
        this.getCustomSkins()
      }
    }
  },
  components: {
    QRSkin
  }
}
</script>

<style>
</style>

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
        icon="format_paint"
        :done="step > 1"
      >
        <q-input
          v-if="type!='template'"
          v-model="search"
          label="Search"
          stack-label
          color="green"
          class="full-width"
          outlined
          :dark="$store.state.DB.dark"
          dense
        />
        <div class="row" style="max-height:calc(100vh - 272px - 32px + 50px);overflow-y:auto;">
          <div v-if="klen != customSkins.length">Loading...</div>
          <div v-if="klen == 0">No Custom Skins</div>
          <div v-for="(s,i) in customSkins.slice().filter(i=>i.SkinName.toLowerCase().includes(search.toLowerCase()))" :key="i" class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 row" style="padding:8px">
            <q-card class="col-12" :class="{'bg-grey-10':$store.state.DB.dark&&s.SkinID!=skin,'bg-grey-8':s.SkinID==skin&&$store.state.DB.dark,'bg-green-2':s.SkinID==skin&&!$store.state.DB.dark}" v-ripple @click="skin=s.SkinID;">
              <q-card-section style="padding:8px;" class="text-center">
                <img style="width:auto;max-height:300px;margin-bottom:-6px;max-width:100%;" :src="s.Data"/>
                <div style="font-weight:bold;">
                  {{s.SkinName}}
                </div>
                <div :class="$store.state.DB.dark?'text-grey-5':'text-grey-8'" style="font-size:0.8em;">Added: {{new Date(s.CreateDate).toLocaleDateString()}}</div>
                <q-btn class="absolute-top-right" @click="del(s.SkinID)" flat round :icon="`img:https://img.icons8.com/material/24/ff0000/delete-forever.png`" />
              </q-card-section>
              <!-- {{s}} -->
            </q-card>
          </div>
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 row" style="padding:8px">
            <q-card class="col-12 flex flex-center" :class="{'bg-grey-10':$store.state.DB.dark}" v-ripple @click="$router.push('/upload')">
              <q-card-section style="padding:8px;" class="text-center">
                <q-icon name="add" size="200px"/>
              </q-card-section>
              <!-- {{s}} -->
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
        title="Insert Munzees"
        icon="list"
      >
        <QRSkin :skin="skin" style="height:300px;"/>

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
          <q-btn flat @click="step = 1" color="green" label="Back" class="q-ml-sm" />
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
      search: '',
      type: '',
      customSkins: [],
      customSkinsLoading: false,
      klen: 1
    }
  },
  computed: {
    url () {
      return `/generate/${this.skin}/${this.munzees.split('\n').filter(i=>i).map(i=>(i.match(/http(?:s)?:\/\/(?:www\.)?munzee.com\/m\/([^/]+)\/(\d+)\/([A-z0-9]{6})(?:\/)?/)||[]).slice(1, 4).join('|')).join(',')}`
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
  created () {
    this.getCustomSkins();
  },
  components: {
    QRSkin
  }
}
</script>

<style>
</style>

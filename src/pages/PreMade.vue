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
        title="Select Skin Types"
        icon="book"
        :done="step > 1"
      >
        <div class="text-h6">Select Skin Types</div>
        Selecting nothing will show all skins.
        <q-select
          :dark="$store.state.DB.dark"
          outlined
          v-model="category"
          :options="categories"
          multiple
          :color="$store.state.DB.dark?'green-8':'black'"
          use-chips
          option-value="CategoryID"
          option-label="CategoryName"
          :options-dark="$store.state.DB.dark"
          options-selected-class="text-green"
        >
          <template v-slot:option="scope">
            <q-item
              v-bind="scope.itemProps"
              v-on="scope.itemEvents"
            >
              <q-item-section>
                <q-item-label v-html="scope.opt.CategoryName" />
                <q-item-label caption>{{ scope.opt.CategoryDesc }}</q-item-label>
              </q-item-section>
            </q-item>
          </template>
          <template v-slot:append>
            <q-icon
              v-if="category.length"
              class="cursor-pointer"
              name="clear"
              @click.stop="category=[]"
            />
          </template>
        </q-select>

        <q-stepper-navigation>
          <q-btn style="margin-right:4px;" @click="step = 2" color="green" label="Continue" />
          <q-btn flat to="/" color="green" label="Back" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>

      <q-step
        :name="2"
        title="Select a Skin"
        icon="format_paint"
        :done="step > 2"
      >
        <div class="text-h6">Select a Skin</div>
        <q-input
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
          <div v-for="(s,i) in skins.filter(x=>{
            var y = true;
            for(var q = 0;q < category.length;q++){
              if(!x.Categories.includes(category[q].CategoryID)) y=false;
            }
            return y;
          }).slice().sort((a,b)=>{
            if (favs.includes(a.SkinID)&&favs.includes(b.SkinID)) {
              return 0;
            } else if (favs.includes(a.SkinID)) {
              return -1;
            } else {
              return 1;
            }
          }).filter(i=>`$$$${i.SkinName} by ${i.SkinOwner}||${i.SkinDesc}^^^`.toLowerCase().includes(search.toLowerCase()))" :key="i" class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 row" style="padding:8px">
            <q-card class="col-12" :class="{'bg-grey-10':$store.state.DB.dark&&s.SkinID!=skin,'bg-grey-8':s.SkinID==skin&&$store.state.DB.dark,'bg-green-2':s.SkinID==skin&&!$store.state.DB.dark}" v-ripple @click="skin=s.SkinID;">
              <q-card-section style="padding:8px;" class="text-center">
                <img style="width:auto;max-height:300px;margin-bottom:-6px;max-width:100%;" :src="`/statics/Skins/${s.SkinOwner.toLowerCase()}/${s.FileName}_tn.${s.FileExt}`"/>
                <div style="font-weight:bold;">
                  {{s.SkinName}} by
                  <span :class="$store.state.DB.dark?`text-light-blue-3`:`text-light-blue-14`">{{s.SkinOwner}}</span>
                </div>
                <q-btn class="absolute-top-right" @click="addFav(s.SkinID)" flat round :icon="`img:https://img.icons8.com/material${favs.includes(s.SkinID)?'':'-outlined'}/24/${favs.includes(s.SkinID)?'ff0000':'d3d3d3'}/like.png`" />
                <div :class="$store.state.DB.dark?'text-grey-4':'text-grey-8'">{{s.SkinDesc}}</div>
                <div :class="$store.state.DB.dark?'text-grey-5':'text-grey-8'" style="font-size:0.8em;">Added: {{new Date(s.CreateDate).toLocaleDateString()}}</div>
              </q-card-section>
              <!-- {{s}} -->
            </q-card>
          </div>
        </div>

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
          <q-btn flat @click="step = 2" color="green" label="Back" class="q-ml-sm" />
        </q-stepper-navigation>
      </q-step>
    </q-stepper>
  </q-page>
</template>

<script>
import Categories from "assets/Categories"
import Skins from "assets/Skins"
import QRSkin from "components/QRSkin"

export default {
  data() {
    return {
      step: 1,
      category: [],
      categories: Categories,
      skin: '',
      skins: Skins,
      munzees: '',
      search: ''
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
    }
  },
  components: {
    QRSkin
  }
}
</script>

<style>
</style>

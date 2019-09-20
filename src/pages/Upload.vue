<template>
  <q-page>
    <picture-input
      v-if="!hasImage"
      ref="pictureInput"
      :height="Math.min($q.screen.height, $q.screen.width)-50"
      :width="Math.min($q.screen.height, $q.screen.width)-50"
      accept="image/jpeg,image/png"
      size="10"
      button-class="btn"
      @change="onChange">
    </picture-input>
    <q-page-sticky v-if="!hasImage" position="bottom-left" :offset="[18, 18]">
      <q-btn @click="$router.push('/')" fab icon="close" color="red" />
    </q-page-sticky>
    <q-inner-loading :dark="$store.state.DB.dark" :showing="loading">
      <q-spinner-ball size="50px" :color="$store.state.DB.dark?'white':'green'"/>
    </q-inner-loading>
    <div v-if="hasImage && !editing">
      <Cropper
        ref="crop"
        style="height: calc(100vh - 50px);"
        :src="img"
        imageClassname="OPAC"
        :stencilProps="{
          previewClassname: 'QRCODE',
          aspectRatio: 1
        }"
      />
      <q-page-sticky position="bottom-left" :offset="[18, 18]">
        <q-btn @click="cancel()" fab icon="close" color="red" />
      </q-page-sticky>
      <q-page-sticky position="bottom-right" :offset="[18, 18]">
        <q-btn @click="edit()" fab icon="done" color="green" />
      </q-page-sticky>

    </div>
    <div style="padding:8px;" v-if="hasImage && editing">
      <q-input v-model="name" label="Name" stack-label dense color="green"/>
      <q-page-sticky position="bottom-left" :offset="[18, 18]">
        <q-btn @click="cancel()" fab icon="close" color="red" />
      </q-page-sticky>
      <q-page-sticky position="bottom-right" :offset="[18, 18]">
        <q-btn @click="done()" fab icon="done" color="green" />
      </q-page-sticky>

    </div>
  </q-page>
</template>

<script>
import lf from "localforage";
import PictureInput from 'vue-picture-input'
import { Cropper } from 'vue-advanced-cropper'

export default {
  // name: 'PageName',
  components: {
    PictureInput,
    Cropper
  },
  data () {
    return {
      hasImage: false,
      loading: false,
      img: '',
      ind: 0,
      editing: false,
      name: '',
      coords: {}
    }
  },
  methods: {
    async onChange (file) {
      // this.loading = true;
      // var keys = await lf.keys();
      // var highest = Math.max(0, ...keys.filter(i=>i.startsWith('img')).map(i=>Number(i.slice(3))))+1;
      // this.ind = highest;
      // await lf.setItem(`img${highest}`, file);
      this.img = file;
      // this.loading = false;
      this.hasImage = true;
    },
    async cancel () {
      // console.log('cancelling')
      // this.loading = true;
      // await lf.removeItem(`img${this.ind}`)
      // this.ind = 0;
      this.editing = false;
      this.img = '';
      this.hasImage = false;
      // this.loading = false;
    },
    async edit () {
      this.coords = this.$refs.crop.getResult().coordinates;
      this.editing = true;
    },
    async done () {
      this.editing = false;
      this.hasImage = false;
      // console.log(this.coords)
      var key = Math.random().toString(36).substring(7)
      await lf.setItem(`custom:${key}`, { SkinID: `custom:${key}`, CreateDate: Date.now(), SkinName: this.name, Data: this.img, QROffsetX: this.coords.left, QROffsetY: this.coords.top, QRSize: this.coords.height });
      this.img = '';
      this.$router.push('/')
    }
  }
}
</script>

<style>
.QRCODE {
  background-image: url("/statics/QR.png");
  background-size: cover;
}
.QRCODE img {
  display:none;
}
.OPAC {
  opacity: 1;
}
</style>

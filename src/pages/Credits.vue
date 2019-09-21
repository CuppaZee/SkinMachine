<template>
  <q-page>
    <q-list :dark="$store.state.DB.dark">
      <q-item>
        <q-item-section avatar>
          <q-avatar size="56px">
            <img src="https://munzee.global.ssl.fastly.net/images/avatars/ua2p5m.png"/>
          </q-avatar>
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-h5">sohcah</q-item-label>
          <q-item-label>Developer of CuppaZee and CuppaZee Skin Machine. </q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section avatar>
          <q-avatar size="56px">
            <img src="/statics/thejoker.png"/>
          </q-avatar>
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-h5">Thejoker</q-item-label>
          <q-item-label>Creator of the original Munzee Skin Machine</q-item-label>
        </q-item-section>
      </q-item>
      <q-item>
        <q-item-section avatar>
          <q-avatar size="56px">
            <img src="https://munzee.global.ssl.fastly.net/images/avatars/ua3ivu.png"/>
          </q-avatar>
        </q-item-section>
        <q-item-section>
          <q-item-label class="text-h5">Brilang</q-item-label>
          <q-item-label>Code Inspiration from ZeePrinter Web App.</q-item-label>
        </q-item-section>
      </q-item>
      <q-item-label header>Skin Creators</q-item-label>
      <div class="row">
        <q-item v-for="(x,i) in creators" :key="i" class="col-12 col-md-6 col-lg-4">
          <q-item-section avatar>
            <q-avatar size="42px">
              <img :src="x[1]||'https://munzee.global.ssl.fastly.net/images/noava.png'"/>
            </q-avatar>
          </q-item-section>
          <q-item-section>
            <q-item-label class="text-h5">{{x[0]}}</q-item-label>
          </q-item-section>
        </q-item>
      </div>
    </q-list>
  </q-page>
</template>

<script>

export default {
  data () {
    return {
      creators: [
        ["1849", "https://munzee.global.ssl.fastly.net/images/avatars/ua8ju.png"],
        ["AdamRootbeer", "https://munzee.global.ssl.fastly.net/images/avatars/ua16zw.png"],
        ["andy1000", "https://munzee.global.ssl.fastly.net/images/avatars/ua1ix1.png"],
        ["bonsaai", "https://munzee.global.ssl.fastly.net/images/avatars/ua1p1i.png"],
        ["chrysalides"],
        ["ddwall", "https://munzee.global.ssl.fastly.net/images/avatars/ua12w8.png"],
        ["dimifw", "https://munzee.global.ssl.fastly.net/images/avatars/uaswg.png"],
        ["dlss", "https://munzee.global.ssl.fastly.net/images/avatars/uaorx.png"],
        ["gof", "https://munzee.global.ssl.fastly.net/images/avatars/uaisi.png"],
        ["jigsaw", "https://munzee.global.ssl.fastly.net/images/avatars/ua1hxh.png"],
        ["jok"],
        ["manzoo", "https://munzee.global.ssl.fastly.net/images/avatars/ua1at0.png"],
        ["PappaPad", "https://munzee.global.ssl.fastly.net/images/avatars/ua4y1.png"],
        ["PFF"],
        ["Pixiewix", "https://munzee.global.ssl.fastly.net/images/avatars/ua1x18.png"],
        ["RebelGTP", "https://munzee.global.ssl.fastly.net/images/avatars/uafz2.png"],
        ["rynee", "https://munzee.global.ssl.fastly.net/images/avatars/uar7.png"],
        ["sohcah", "https://munzee.global.ssl.fastly.net/images/avatars/ua2p5m.png"],
        ["tango71", "https://munzee.global.ssl.fastly.net/images/avatars/uatje.png"],
        ["thejoker", "/statics/thejoker.png"],
        ["WanderingAus", "https://munzee.global.ssl.fastly.net/images/avatars/ua11y6.png"],
        ["winkide", "https://munzee.global.ssl.fastly.net/images/avatars/ua7fe.png"],
        ["zalskinz"],
        ["zork", "https://munzee.global.ssl.fastly.net/images/avatars/ua396.png"]
      ]
    }
  }
}
</script>

<style>
</style>

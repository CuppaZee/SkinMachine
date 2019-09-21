<template>
  <q-page>
    <div v-for="(url,i) in urls" :key="i" style="padding:8px;display:inline-block;">
      <QRSkin :skin="skin" :url="url" style="height:300px;"/>
    </div>
  </q-page>
</template>

<script>
import QRSkin from "components/QRSkin"

export default {
  computed: {
    urls () {
      return this.$route.params.munzees.split(',').map(i=>i.split('|'))
    },
    skin () {
      return decodeURIComponent(this.$route.params.skin);
    }
  },
  components: {
    QRSkin
  }
}
</script>

<style>
</style>

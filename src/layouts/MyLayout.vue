<template>
  <q-layout :class="$store.state.DB.dark?'bg-grey-9':'bg-white'" view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar :class="$store.state.DB.dark?'bg-grey-10':'bg-green'">
        <q-btn
          flat
          dense
          round
          @click="leftDrawerOpen = !leftDrawerOpen"
          aria-label="Menu"
        >
          <q-icon name="menu" />
        </q-btn>

        <q-toolbar-title>
          CuppaZee Skin Machine
        </q-toolbar-title>

        <div>v0.0.1</div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :content-class="$store.state.DB.dark?'bg-grey-10':'bg-grey-2'"
    >
      <q-list :dark="$store.state.DB.dark">
        <q-item clickable tag="a" href="https://cuppazee.uk/">
          <q-item-section avatar>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/24/${$store.state.DB.dark?'ffffff':'000000'}/exit-sign.png`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Return to CuppaZee</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable tag="a" @click="dark">
          <q-item-section avatar>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/24/${$store.state.DB.dark?'ffffff':'000000'}/${$store.state.DB.dark?'summer':'moon'}.png`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Switch to {{$store.state.DB.dark?'Light':'Dark'}} Mode</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable tag="a" href="https://github.com/CuppaZee/SkinMachine">
          <q-item-section avatar>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/24/${$store.state.DB.dark?'ffffff':'000000'}/github.png`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Source Code</q-item-label>
          </q-item-section>
        </q-item>
        <p style="padding-left:4px;padding-right:4px;">
          <b><q-icon name="lock"/> PRIVACY</b><br>
          All processing is done on your device.<br>Your Munzee URLs, Secret Codes and Skins will <b style="text-decoration:underline;">never</b> leave your device!
        </p>
        <p style="padding-left:4px;padding-right:4px;">
          <b><q-icon name="close"/> Missing Features</b><br>
          We currently only support <b>Basic</b> pre-made skins. Custom skins will be supported soon. You can submit your skins at mail@cuppazee.uk.<br>
          We currently do not support "Deployed by" texts on pre-made skins. This will be added soon.<br>
          We currently cannot generate PDFs. This will be coming soon.
        </p>
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import { openURL } from 'quasar'

export default {
  name: 'MyLayout',
  data () {
    return {
      leftDrawerOpen: false
    }
  },
  methods: {
    openURL,
    dark () {
      if (this.$store.state.DB.dark) {
        delete localStorage.dark
      } else {
        localStorage.dark = 'true'
      }
      location.reload()
    }
  }
}
</script>

<style>
</style>

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
        <q-item-label header>Tools</q-item-label>
        <q-item clickable exact to="/">
          <q-item-section avatar>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/24/${$store.state.DB.dark?'ffffff':'000000'}/paint.png`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>The Skin Machine</q-item-label>
          </q-item-section>
        </q-item>
        <q-item clickable to="/upload">
          <q-item-section avatar>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/24/${$store.state.DB.dark?'ffffff':'000000'}/upload.png`" />
          </q-item-section>
          <q-item-section>
            <q-item-label>Upload Skins</q-item-label>
          </q-item-section>
        </q-item>
        <q-item-label header>Other</q-item-label>
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
          We currently do not support "Deployed by" texts on pre-made skins. This will be added soon.<br>
          We currently cannot generate PDFs. This will be coming soon.
        </p>
        <p style="padding-left:4px;padding-right:4px;">
          <b><q-icon name="check"/> Submit</b><br>
          You can submit your skins to mail@cuppazee.uk.
        </p>
        <p style="padding-left:4px;padding-right:4px;">
          <b><q-icon name="person"/> Credits</b><br>
          Created by sohcah.<br>
          Idea from the original Munzee Skin Machine by thejoker.<br>
          Code Inspiration from ZeePrinter Web App by Brilang.<br>
          Skin Designers are credited separately.
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

<template>
  <q-page class="flex flex-center">
    <div class="row full-width justify-center">
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <router-link to="/premade" style="text-decoration:none;">
          <q-card class="bg-green text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/wallpaper.png" size="150px" />
              <div class="text-h6">Pre-made Skins</div>
            </q-card-section>
          </q-card>
        </router-link>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <router-link to="/template" style="text-decoration:none;">
          <q-card class="bg-blue text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/vertical-settings-mixer.png" size="150px" />
              <div class="text-h6">Template Skins</div>
            </q-card-section>
          </q-card>
        </router-link>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <router-link to="/custom" style="text-decoration:none;">
          <q-card class="bg-deep-orange text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/upload-to-cloud.png" size="150px" />
              <!-- placeholder-thumbnail-document -->
              <div class="text-h6">Custom Skins</div>
            </q-card-section>
          </q-card>
        </router-link>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <a href="https://cuppazee.uk/" style="text-decoration:none;">
          <q-card class="bg-purple text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/exit-sign.png" size="150px" />
              <!-- placeholder-thumbnail-document -->
              <div class="text-h6">Return to CuppaZee</div>
            </q-card-section>
          </q-card>
        </a>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <q-card class="bg-blue-grey text-white text-center" @click="dark()" v-ripple>
          <q-card-section>
            <q-icon :name="`img:https://img.icons8.com/material-outlined/150/ffffff/${$store.state.DB.dark?'summer':'moon'}.png`" size="150px" />
            <!-- placeholder-thumbnail-document -->
            <div class="text-h6">{{$store.state.DB.dark?'Light':'Dark'}} Mode</div>
          </q-card-section>
        </q-card>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <router-link to="/credits" style="text-decoration:none;">
          <q-card class="bg-pink text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/trust.png" size="150px" />
              <!-- placeholder-thumbnail-document -->
              <div class="text-h6">Credits</div>
            </q-card-section>
          </q-card>
        </router-link>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <router-link to="/submit" style="text-decoration:none;">
          <q-card class="bg-teal text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/send-to-cloud.png" size="150px" />
              <!-- placeholder-thumbnail-document -->
              <div class="text-h6">Submit Skins</div>
            </q-card-section>
          </q-card>
        </router-link>
      </div>
      <div class="col-12 col-sm-6 col-lge-3" style="padding:8px;">
        <a href="https://github.com/CuppaZee/SkinMachine" style="text-decoration:none;">
          <q-card style="background-color: #24292e" class="text-white text-center" v-ripple>
            <q-card-section>
              <q-icon name="img:https://img.icons8.com/material-outlined/150/ffffff/github.png" size="150px" />
              <!-- placeholder-thumbnail-document -->
              <div class="text-h6">Source Code</div>
            </q-card-section>
          </q-card>
        </a>
      </div>
    </div>
  </q-page>
</template>

<script>

export default {
  methods: {
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

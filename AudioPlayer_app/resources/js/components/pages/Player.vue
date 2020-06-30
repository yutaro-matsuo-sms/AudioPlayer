<template>
  <v-app>
    <v-toolbar dark color="primary">
      <v-toolbar-title white--text>Music Metronome</v-toolbar-title>
    </v-toolbar>
    <v-card class="transparent">
      <v-container fluid grid-list-xs>
        <v-layout row wrap>
          <v-flex xs12 md6 lg4 xl4 offset-md3 offset-lg4 offset-xl4>
            <v-card>
              <v-card-text>
                <AudioPlayer />
              </v-card-text>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-card>
  </v-app>
</template>

<script>
import AudioPlayer from "../elements/AudioPlayer";
export default {
  name: "Player",
  components: {
    AudioPlayer: AudioPlayer
  },
  data() {
    return {};
  }
};
</script>

<style scoped>
.soundLink a {
  color: white;
}
</style>
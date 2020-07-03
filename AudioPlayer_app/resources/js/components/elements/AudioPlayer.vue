<template>
  <v-container v-if="songs[songIndex]">
    <v-layout low, wrap>
      <v-flex v-if="songs[songIndex]" xs12>
        <v-card class="mx-auto" max-width="320">
          <v-img height="220px" :src="songs[songIndex].image" />
        </v-card>
        <v-card-text>{{songs[songIndex].name}}</v-card-text>
        <v-card-text>{{songs[songIndex].artist}}</v-card-text>
      </v-flex>
    </v-layout>
    <v-layout row wrap align-center justify-center>
      <v-flex text-md-right>
        <v-card-text>{{toCurrentMs}} / {{toDurationMs}}</v-card-text>
        <v-slider v-model="currentTime" @end="changeSeek" :min="0" :max="duration" color="primary" />
      </v-flex>
    </v-layout>
    <v-layout row wrap align-center>
      <v-flex text-md-right>
        <v-icon x-large dark color="primary" @click.prevent="prev">mdi-rewind</v-icon>
      </v-flex>
      <v-flex text-md-center>
        <template v-if="!isPlay">
          <v-icon x-large dark color="primary" @click.prevent="play">mdi-play</v-icon>
        </template>
        <template v-else>
          <v-icon x-large dark color="primary" @click.prevent="pause">mdi-pause</v-icon>
        </template>
      </v-flex>
      <v-flex text-md-left>
        <v-icon x-large dark color="primary" @click.prevent="next">mdi-fast-forward</v-icon>
      </v-flex>
    </v-layout>
    <v-layout row wrap align-center>
      <v-flex text-xs-right>
        <v-slider
          v-model="audioVol"
          append-icon="mdi-volume-high"
          prepend-icon="mdi-volume-low"
          :min="0"
          :max="100"
        />
      </v-flex>
    </v-layout>
    <v-layout row wrap align-center>
      <v-flex text-md-right>
        <v-icon dark color="primary" @click.prevent="showPlayList">mdi-format-list-bulleted</v-icon>
      </v-flex>
      <v-flex text-md-center>
        <template v-if="!songs[songIndex].is_favorite">
          <v-icon dark color="primary" @click.prevent="changeFavorite">mdi-heart-outline</v-icon>
        </template>
        <template v-else>
          <v-icon dark color="primary" @click.prevent="changeFavorite">mdi-heart</v-icon>
        </template>
      </v-flex>
      <v-flex text-md-left>
        <v-icon dark color="primary" @click.prevent="addPlayList">mdi-playlist-plus</v-icon>
      </v-flex>
    </v-layout>
    <v-layout low, wrap>
      <v-flex xs12>
        <template v-if="onPlayList">
          <v-card class="mx-auto" max-width="320">
            <v-list disabled>
              <v-list-item-group dark v-model="songs">
                <v-list-item v-for="(song, i) in songs" :key="i">
                  <v-list-item-content>
                    <v-list-item-titl v-text="song.name"></v-list-item-titl>
                  </v-list-item-content>
                </v-list-item>
              </v-list-item-group>
            </v-list>
          </v-card>
        </template>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import { Howl, Howler } from "howler";
import { getSongs, updateSong } from "../../lib/api-service";
export default {
  name: "AudioPlayer",
  compornents: {},
  data: function() {
    return {
      songs: [],
      audio: {
        song: null
      },
      duration: 0,
      currentTime: 0,
      timer: null,
      songIndex: 0,
      audioVol: 100,
      onPlayList: false
    };
  },
  mounted: function() {
    this.loadSongs();
  },
  methods: {
    async loadSongs() {
      try {
        this.songs = await getSongs();
        this.initHowl();
      } catch (e) {
        this.songs = [];
        console.log(e);
      }
    },
    initHowl() {
      this.audio.song = new Howl({
        src: this.songs[this.songIndex].song,
        volume: this.toVol
      });
      this.audio.song.on("load", () => {
        this.duration = this.audio.song.duration();
      });
      this.audio.song.on("play", () => {
        this.timer = setInterval(() => {
          let seek = this.audio.song.seek();
          this.currentTime = seek;
        }, 200);
      });
      this.audio.song.on("pause", () => {
        clearInterval(this.timer);
      });
      this.audio.song.on("stop", () => {
        clearInterval(this.timer);
      });
      this.audio.song.on("end", () => {
        clearInterval(this.timer);
        this.currentTime = 0;
        this.songIndex += 1;
        this.audio.song = new Howl({
          src: this.songs[this.songIndex].song,
          volume: this.toVol
        });
        this.audio.song.once("load", () => {
          this.duration = this.audi.song.duration();
        });
        this.play();
      });
    },
    showPlayList() {
      return (this.onPlayList = !this.onPlayList);
    },
    playChangeSeek(seek) {
      this.audio.song.seek(seek).mute(false);
      if (this.isPlay) {
        this.audio.song.play();
      }
    },
    playAudio(audio) {
      audio.mute(false);
      audio.play();
    },
    play() {
      this.playAudio(this.audio.song);
    },
    pause() {
      this.audio.song.pause();
    },
    prev() {
      const currentSt = this.isPlay;
      this.audio.song.stop();
      this.currentTime = 0;
      this.songIndex -= 1;
      if (this.songIndex < 0) {
        this.songIndex = this.songs.length - 1;
      }
      this.initHowl();
      if (currentSt === true) {
        console.log("きてます");
        this.audio.song.play();
      }
    },
    next() {
      const currentSt = this.isPlay;
      this.audio.song.stop();
      this.currentTime = 0;
      this.songIndex += 1;
      if (this.songIndex > this.songs.length - 1) {
        this.songIndex = 0;
      }
      this.initHowl();
      if (currentSt === true) {
        this.audio.song.play();
      }
    },
    changeSeek(seek) {
      this.audio.song.stop();
      this.playChangeSeek(seek);
    },
    async changeFavorite() {
      this.songs[this.songIndex].is_favorite = !this.songs[this.songIndex]
        .is_favorite;
      try {
        await updateSong(
          this.songs[this.songIndex].id,
          this.songs[this.songIndex]
        );
      } catch (e) {
        console.log(e);
        this.songs[this.songIndex].is_favorite = !this.songs[this.songIndex]
          .is_favorite;
      }
    },
    padZero(v) {
      if (v < 10) {
        return "0" + Math.ceil(v);
      } else {
        return Math.ceil(v);
      }
    },
    toTime() {
      return this.toCurrentMs() + "/" + this.toDurationMs();
    }
  },
  computed: {
    toCurrentMs() {
      let minutes = ((this.currentTime % 3600) / 60) | 0;
      const second = this.padZero(this.currentTime % 60);
      if (second === "60") {
        return parseInt(minutes) + 1 + ":" + "00";
      }
      return minutes + ":" + second;
    },
    toDurationMs() {
      let minutes = ((this.duration % 3600) / 60) | 0;
      const second = this.padZero(this.duration % 60);
      if (second === 60) {
        return parseInt(minutes) + 1 + ":" + "00";
      }
      return minutes + ":" + second;
    },
    getSongIndex() {
      if (this.songIndex === this.songs.length - 1) {
        return this.songIndex - this.songIndex;
      }
      return this.songIndex + 1;
    },
    toVol() {
      return this.audioVol / 100;
    },
    isPlay() {
      return this.audio.song.playing() === true;
    }
  },
  watch: {
    audioVol: function(vol) {
      Howler.volume(vol / 100);
    }
  }
};
</script>
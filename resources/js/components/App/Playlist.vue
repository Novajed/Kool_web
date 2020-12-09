<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> {{ playlist.name }}</div>
          <div class="card-body">
            <ul class="list-group">
              <li v-if="loading" class="list-group-item"><div class="d-flex justify-content-center">
  <div class="spinner-border text-info" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div></li>
              <li v-else v-for="song in songs" :key="song.id" class="list-group-item">
                <router-link :to="{path: '/video/' + song.id }">{{song.title}}</router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      songs: {},
      playlist: {},
      loading: true
    }
  },
  mounted() {
    this.getData()
  },
  methods: {
    getData() {
      this.getPlaylist()
      this.getSongs()
    },
    getSongs() {
      axios.get('/api/playlists/' + this.$route.params.playlist_id + '/songs')
        .then(response => {
          this.songs = response.data
          this.loading = false
        });
    },
    getPlaylist() {
      axios.get('/playlists/' + this.$route.params.playlist_id)
        .then(response => {
          this.playlist = response.data
        });
    },
    back() {
      this.$router.go(-1)
    }
  }
}
</script>

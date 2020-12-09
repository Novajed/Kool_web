<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> {{subject_name}} Grade {{this.grade}}
          </div>
          <div class="card-body">
            <ul class="list-group">
              <li v-if="loading" class="list-group-item">
                <div class="d-flex justify-content-center">
                  <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              </li>
              <li v-else v-for="song in songs" :key="song.id" class="list-group-item">
                <router-link :to="{path: '/video/' + song.id }">{{song.title}}</router-link><span style="float:right"><button type="button" class="btn btn-sm btn-primary" @click="addSongToPlaylistModal(song.id)">Add To Playlist</button></span></li>
            </ul>
          </div>
          
        </div>
      </div>
    </div>
    <!--MODAL -->
    <div class="modal" id="addSongToPlaylistModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select a Playlist</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <button class="btn btn-primary" @click="newPlaylist">
                Create New Playlist
              </button>
            </div>
            <div class="row">
              <ul v-if="playlists.length" class="list-group">
                <li v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                  <a href="#" @click="addSongToPlaylist(playlist.id)">{{playlist.name}}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Finish</button>
          </div>
        </div>
      </div>
    </div>
    <!--MODAL -->
    <!--MODAL -->
    <div class="modal" id="newPlaylistModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">New Playlist</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="playlist name">Enter Playlist Name</label>
                <input v-model="playlist.name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" aria-describedby="playlist name" placeholder="Enter playlist name">
                <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="createPlaylist">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!--MODAL -->
  </div>
</template>

<script>
export default {
  data() {
    return {
      songs: {},
      grade: this.$route.params.grade,
      subject: this.$route.params.subject,
      subject_name:'',
      url: '',
      loading: true,
      playlists: {},
      playlist: {},
      user: {},
      message: '',
      songId: '',
      errors: {}
    }
  },
  mounted() {
    console.log('mounted')
    this.url = '/api/grade/' + this.grade + '/subject/' + this.subject
    this.getSongs()
    this.user = this.$root.$data.user
    this.getPlaylists()
    this.getSubject()
  },
  methods: {
    getSongs() {
      axios.get(this.url)
        .then(response => {
          this.songs = response.data
          this.loading = false
        });
    },
    addSongToPlaylistModal(song_id) {
      this.songId = song_id
      $('#addSongToPlaylistModal').modal('show');
    },
    addSongToPlaylist(playlist_id) {

      axios.get('/playlists/' + playlist_id + '/song/' + this.songId)
        .then(response => {
          this.playlists = response.data
        });
      this.getPlaylists()
    },
    getPlaylists() {
      let $this = this
      axios.get('/api/playlists/' + this.user.id)
        .then(response => {
          this.playlists = response.data
        });
    },
    newPlaylist() {
      $('#addSongToPlaylistModal').modal('hide');
      $('#newPlaylistModal').modal('show');
    },
    createPlaylist() {
      axios.post('/playlists', {
          name: this.playlist.name
        })
        .then(function(response) {
          $('#newPlaylistModal').modal('hide');
        })
      this.getPlaylists()
    },
    back() {
      history.go(-1)
    },
    getSubject(){
      let subjects = ['','ELA','Math','Science', 'Social Studies']
      this.subject_name = subjects[this.subject]
    }
  }


}
</script>

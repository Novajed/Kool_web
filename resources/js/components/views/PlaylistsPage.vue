<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a>My Playlists </div>
          <div class="card-body">
            <div class="row justify-content-between new-playlist">
              <div class="col-lg-4 float-right desktop-order-2">
                <a class="btn btn-primary text-white" @click="newPlaylist">
                        Create New Playlist
                      </a>
              </div>
              <div class="col-md-7 float-left desktop-order-1">
                <ul  class="list-group">
                  <li v-if="loading" class="list-group-item">
                  <div class="d-flex spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </li>
                  <li v-else v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                    <router-link :to="{path: '/playlist/' + playlist.id }">{{playlist.name}}</router-link><span><a class="list-icon" href="#" @click="deletePlaylist(playlist.id)"><i class="fa fa-trash" aria-hidden="true"></i></a></span>
                  </li>
                </ul>
              </div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
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
            <div v-if="added" class="alert alert-success small-blur" role="alert">
              Your changes has been saved!
            </div>
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
      loading: true,
      playlists: {},
      url: '/api/playlists/' + this.$route.params.user_id,
      added: false,
      playlist: {},
      errors: {}
    }
  },
  mounted() {
    this.getPlaylists()


  },
  methods: {
    getPlaylists() {
      let $this = this
      axios.get(this.url)
        .then(response => {
          this.playlists = response.data
          this.loading = false
        });
    },
    newPlaylist() {
      this.added = false
      $('#newPlaylistModal').modal('show');
    },
    createPlaylist() {
      axios.post('/playlists', {
          name: this.playlist.name
        })
        .then(function(response) {
          $('#newPlaylistModal').modal('hide');
        })
      this.playlist = ''
      this.getPlaylists()
    },
    deletePlaylist(playlist_id) {
      if (confirm('Do you really want to delete?')) {
        axios.delete('/playlists/' + playlist_id)
      }
      this.getPlaylists()
    },
    back() {
      this.$router.go(-1)
    }
  }
}
</script>

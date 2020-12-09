<template>
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
          <ul v-if="user.playlists.length" class="list-group">
            <li v-for="playlist in user.playlists" :key="playlist.id" class="list-group-item">
              <a href="javascript:void(0)" @click="addPlaylistToClass(playlist.id)">{{playlist.name}}</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Finish</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getPlaylists()
  },
  data() {
    return {
      playlists: {}
    }
  },
  methods: {
    newPlaylist() {
      this.$emit('my-event')
    },
    addPlaylistToClass(playlist_id) {
      axios.get('/classrooms/' + this.$route.params.classroom_id + '/playlists/' + playlist_id)
      $('#addPlaylistToClassModal').modal('hide');
      this.getClassroomPlaylists()
    },
    getClassroomPlaylists() {
      axios.get('/api/classrooms/' + this.$route.params.classroom_id + '/playlists')
        .then(res => {
          this.playlists = res.data
        })
    },
  }
}
</script>

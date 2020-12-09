<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> Playlists for {{classroom.name}}</div>
          <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm btn-block" @click="addPlaylistToClassModal">Add Playlist</button>
            <ul class="list-group">
              <li v-if="loading" class="list-group-item"><strong>Loading...</strong></li>
              <li v-else v-for="playlist in playlists" :key="playlist.id" class="list-group-item">
                <router-link :to="{path: '/playlist/' + playlist.id }">{{playlist.name}}</router-link><span style="float:right"><button type="button" class="btn btn-sm btn-primary" >Button</button></span></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Students</div>
          <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm btn-block" @click="addStudentToClassModal">Add Students</button>
            <ul class="list-group">
              <li v-if="loading" class="list-group-item"><strong>Loading...</strong></li>
              <li v-else v-for="student in students" :key="student.id" class="list-group-item">
                <router-link :to="{path: '/video/' + student.id }">{{student.name}}</router-link><span style="float:right"><button type="button" class="btn btn-sm btn-primary">Button</button></span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!--MODAL -->
    <div class="modal" id="addPlaylistToClassModal" tabindex="-1" role="dialog">
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
                <input v-model="form.playlist.name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" aria-describedby="playlist name" placeholder="Enter playlist name">
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

    <div class="modal" id="addStudentToClassModal" tabindex="-1" role="dialog">
      <add-students></add-students>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getClassroom()
    this.getPlaylists()
    this.getClassroomPlaylists()
    this.getClassroomStudents()
  },
  data() {
    return {
      classroom: {
        name: ''
      },
      students: {},
      playlists: {},
      url: '/classrooms/' + this.$route.params.classroom_id,
      loading: true,
      user: {
        playlists: {}
      },
      errors: {},
      form: {
        playlist: {}
      },
      postedPlaylist: ''
    }
  },
  methods: {
    getClassroom() {
      axios.get(this.url)
        .then(res => {
          this.classroom = res.data

        });
      this.loading = false
    },
    back() {
      this.$router.go(-1)
    },
    addPlaylistToClassModal() {
      $('#addPlaylistToClassModal').modal('show');
    },
    addStudentToClassModal() {
      $('#addStudentToClassModal').modal('show');
    },
    getPlaylists() {
      axios.get('/api/teacher-playlists')
        .then(res => {
          this.user.playlists = res.data
        })
    },
    newPlaylist() {
      $('#addPlaylistToClassModal').modal('hide');
      $('#newPlaylistModal').modal('show');
    },
    addPlaylistToClass(playlist_id) {
      axios.get('/classrooms/' + this.$route.params.classroom_id + '/playlists/' + playlist_id)
      $('#addPlaylistToClassModal').modal('hide');
      this.getClassroomPlaylists()

    },
    createPlaylist() {
      axios.post('/playlists/classroom/' + this.$route.params.classroom_id, {
          name: this.form.playlist.name
        })
      $('#newPlaylistModal').modal('hide');  
      this.form.playlist.name = ''
      this.getPlaylists()
      $('#addPlaylistToClassModal').modal('show');
      


    },
    getClassroomPlaylists() {
      axios.get('/api/classrooms/' + this.$route.params.classroom_id + '/playlists')
        .then(res => {
          this.playlists = res.data
          console.log(res.data)
        })
    },
    getClassroomStudents() {
      axios.get('/api/classrooms/' + this.$route.params.classroom_id + '/students')
        .then(res => {
          this.students = res.data
        })
    }
  }
}
</script>

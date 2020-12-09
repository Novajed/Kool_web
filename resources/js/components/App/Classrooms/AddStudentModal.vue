<template>
  <!--MODAL -->
    
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Select students</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div v-if="loading" class="d-flex justify-content-center">
                  <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
              <ul v-else class="list-group">
                <li v-for="student in students" :key="student.id" class="list-group-item">
                  <a href="javascript:void(0)">{{student.name}}</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Finish</button>
          </div>
        </div>
      </div>
    <!--MODAL -->
</template>

<script>
export default {
  mounted(){
    this.getStudents()
  },
  data(){
    return {
      students:{},
      loading:true
    }
  },
  methods:{
    getStudents() {
      axios.get('/api/classrooms/available-students')
        .then(res => {
          this.students = res.data

        });
      this.loading = false
  }
}
}
</script>

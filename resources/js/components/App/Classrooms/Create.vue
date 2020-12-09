<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> Create Classroom</div>
          <div class="card-body">
            <form @submit="formSubmit">
              <div class="form-group">
                <label for="name">Classroom Name</label>
                <input v-model="classroom.name" type="text" class="form-control" aria-describedby="name" placeholder="Enter classroom name" required>
              </div>
              <div class="form-group">
                <label v-if="students.length" for="grades">Select Students</label>
                <div v-for="student in students" :key="student.id" class="form-check">
                  <input :value="student.id" v-model="selectedStudents" class="form-check-input" type="checkbox">
                  <label class="form-check-label">{{ student.name }}</label>
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getStudents()
  },
  data() {
    return {
      classroom: {
        name: ''
      },
      students: {},
      selectedStudents: []

    }
  },
  methods: {
    getStudents() {
      axios.get('/api/classrooms/available-students')
        .then(response => {
          this.students = response.data
        });
    },
    formSubmit(e) {
      e.preventDefault();
      let $this = this;
      axios.post('/classrooms', {
        name: this.classroom.name,
        students: this.selectedStudents
      })
      this.$router.push({ path: '/portal/classrooms' })
    },
    back() {
      this.$router.go(-1)
    }
  }
}
</script>

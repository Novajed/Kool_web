<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> My Classes</div>
          <div class="card-body">
            <div class="row">
              <div class="col">
                <router-link to="/portal/classrooms/create" class="btn btn-primary">
                  Create New Classroom
                </router-link>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-12">
                <ul v-if="classrooms.length" class="list-group">
                  <li v-for="classroom in classrooms" :key="classroom.id" class="list-group-item">
                    <router-link :to="{path: '/portal/classrooms/' + classroom.id }">{{classroom.name}}</router-link><span class="float-right"><a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></span></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    this.getClassrooms()
  },
  data() {
    return {
      url: '/api/classrooms',
      classrooms: {}
    }
  },
  methods: {
    getClassrooms() {
      axios.get(this.url)
        .then(response => {
          this.classrooms = response.data
        });
    },
    back() {
      this.$router.go(-1)
    }
  }
}
</script>

<template>
  <div class="card">
    <div class="card-header">Classrooms</div>
    <div class="card-body">
      <div class="row justify-content-between new-classroom">
        <div class="col-md-12">
          <div class="row">
            <div class="col">
              <a class="btn btn-primary text-white">
                        Find Classes
                </a>
            </div>
          </div>

          <div class="row mt-3">
            <div class="col-md-12">
              <ul class="list-group">
                <li v-if="loading" class="list-group-item">
                  <div class="d-flex justify-content-center">
                  <div class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                </li>
                <li v-else v-for="classroom in classrooms" class="list-group-item">
                  <router-link :to="{path: '/classroom/' + classroom.id }">{{classroom.name}}</router-link><span><a class="list-icon" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></span>
                </li>
              </ul>
            </div>
          </div>
          <div class="row mt-3">
          	<div class="col">
          	<router-link v-if="!loading && classrooms.length > 5" to="/">View All</router-link>
          </div>
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
      classrooms: {},
      loading: true,
      user: {}
    }
  },
  mounted() {
    this.getClassrooms()
  },
  methods: {
    getClassrooms() {
      axios.get('/classrooms')
        .then(response => {
          this.classrooms = response.data
          this.loading = false
        });
    }

  }
}
</script>

<style>
bottom-margin {
  margin-bottom: 1em !important;
}
</style>

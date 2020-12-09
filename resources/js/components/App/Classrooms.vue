<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Classrooms</div>
          <div class="card-body">
            <div class="row justify-content-between new-classroom">
              <div class="col-lg-4 float-right desktop-order-2">
                <a class="btn btn-primary text-white">
                        Find Classes
                      </a>
              </div>
              <div class="col-md-7 float-left desktop-order-1">
                <ul v-if="classrooms.length" class="list-group">
                  <div v-if="loading" class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                  <li v-else v-for="classroom in classrooms" :key="classroom.id" class="list-group-item">
                    <router-link :to="{path: '/classroom/' + classroom.id }">{{classroom.name}}</router-link><span><a class="list-icon" href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></span>
                  </li>
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
  data() {
    return {
      loading: true,
      classrooms: {}
    }
  },
  mounted() {
    this.getClassrooms()
  },
  methods: {
    getClassrooms() {
      axios.get('/api/classrooms')
        .then(response => {
          this.classrooms = response.data
          this.loading = false
        });
    }
  }
}
</script>

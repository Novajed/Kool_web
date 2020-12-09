<template>
  <div class="container">
    <!--Loading -->
      <loading-screen v-if="loading"></loading-screen>
    
    <!-- App -->

      <div v-else class="row">
        <search></search>

        <div class="col-md-9 desktop-order-2">
          <grades></grades>
        </div>
        <div class="col-md-3 desktop-order-1">
          <div v-if="user.organization_id">
            <classrooms-widget></classrooms-widget>
          </div>
        </div>

        
      </div>
    </div>
</template>

<script>
export default {
  mounted() {
    this.getData()

  },
  data() {
    return {
      loading:true,
      user: {
        organization_id: false
      },
      grade: ''
    }
  },
  methods: {
    getData(){
      axios.get('/api/user')
        .then(response => {
          this.user = response.data
          this.loading = false
        });
    }
  }
}
</script>

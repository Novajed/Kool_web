<template>
  <div>
    <classrooms></classrooms>
  </div>
</template>

<script>
export default {
  mounted() {

  },
  data() {
    return {

    }
  },
  methods:{
    getClassrooms() {
      axios.get('/api/classrooms')
        .then(response => {
          this.classrooms = response.data
        });
      this.loading = false
    }
  }

}
</script>

<template>
  <input type="text" class="form-control" v-model="query" v-on:keyup="search">
</template>
<script>
  export default {
    data() {
      return {
        query:'',
      }
    },
    methods:{
      search(e) {
        e.preventDefault()
        axios.post('/api/search', {
          qry: this.query,
        }).then(function(res) {
          console.log(res)
        });
      }
    }
  }
</script>
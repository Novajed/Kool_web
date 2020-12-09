<template>
 <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <ul class="list-group">
            <li v-for="user in users" :key="user.id" class="list-group-item">{{user.name}}</li>
          </ul>
        </div>
        <nav aria-label="Pagination">
          <ul class="pagination">
            <li v-bind:class="{'disabled':(!pagination.prev_page_url),'page-item' : true}">
              <button class="page-link" v-on:click="fetchPaginateUsers(pagination.prev_page_url)">Previous</button>
            </li>
            <span class="current-page">page {{pagination.current_page}} of {{pagination.last_page}}</span>
            <li v-bind:class="{'disabled':(!pagination.next_page_url),'page-item' : true}">
              <button class="page-link" v-on:click="fetchPaginateUsers(pagination.next_page_url)">Next</button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      url: '/api/test',
      pagination: []
    }
  },
  beforeMount() {
    this.$Progress.start()
    this.getUsers()
    this.$Progress.finish()
  },
  methods: {
    getUsers() {
      let $this = this
      axios.get(this.url)
        .then(response => {
          this.users = response.data.data
          $this.makePagination(response.data)
        });
    },
    makePagination(data) {
      let pagination = {
        current_page: data.current_page,
        last_page: data.last_page,
        next_page_url: data.next_page_url,
        prev_page_url: data.prev_page_url
      }
      this.pagination = pagination
    },
    fetchPaginateUsers(url) {
      this.url = url
      this.getUsers()
    }


  }
}
</script>

<style>
.current-page {
  margin: .5em;
}
</style>

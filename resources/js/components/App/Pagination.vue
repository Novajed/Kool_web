<template>
  <nav aria-label="Page navigation example">
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
</template>

<script>
export default {
  data() {
    return {
    	pagination: {}
    }
  },
  props:['response'],
  mounted(){
  	this.makePagination(this.$props.response.data)
  },
  methods: {
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
      this.$emit('get-method',url)
    }
  }
}
</script>

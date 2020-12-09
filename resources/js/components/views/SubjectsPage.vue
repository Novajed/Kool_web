<template>
  <div class="container">
    <subjects v-bind:grade="grade"></subjects>
  </div>
</template>

<script>
export default {
  data() {
    return {
      grade: this.$route.params.grade
    }
  },
  mounted() {
    console.log('mounted')
  }
}
</script>

<template>
  <div class="container">
    <video-player v-bind:song="song"></video-player>
  </div>
</template>

<script>
export default {
  data() {
    return {
      song: {},
      url: '/songs/' + this.$route.params.video_id,

    }
  },
  mounted() {
    this.getSong()
  },
  methods: {
    getSong() {
      axios.get(this.url)
        .then(response => {
          console.log(response.data)
          this.song = response.data
          this.loading = false
        });
    }
  }
}
</script>

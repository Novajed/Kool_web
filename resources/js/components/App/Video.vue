<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a> {{ song.title }}</div>
        <div class="card-body">
          <div class="embed-responsive embed-responsive-16by9">
            <video class="embed-responsive-item" autoplay="false" :src="song.src" controls allowfullscreen></video>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('compoonemt')
  },
  methods: {
    back() {
      this.$router.go(-1)
    }
  },
  props: ['song']
}
</script>

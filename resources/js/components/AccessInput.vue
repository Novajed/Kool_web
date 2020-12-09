<template>
  <div class="card-body">
    <div class="form-group row">
      <label for="access_code" class="col-md-4 col-form-label text-md-right">Have an access code?</label>
      <div class="col-md-6">
        <input class="form-control" v-model="access_code" autofocus>
      </div>
    </div>
    <div class="form-group row mb-0">
      <small v-if="errors == true" class="text-danger">The given data was invalid</small>
      <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary" @click="submitForm">
          Next
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Mounted')
  },
  data() {
    return {
      access_code: '',
      errors: false,
      url: '',
      errors: {}
    };
  },
  props: ['guard'],
  methods: {
    submitForm() {
      const router = this.$router
      axios.post('/access-code', {
          access_code: this.access_code,
          guard: this.$props.guard
        })
        .then(function(response) {
          console.log('then')
          router.push({ path: 'home' })
          router.go('/home')
        })
        .catch(function(errors) {
          console.log('error')
        })
    }
  }


}
</script>

<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <router-link to="/admin/users"><i class="fas fa-arrow-left"></i></router-link> Register New Organization</div>
        <div class="card-body">
          <form @submit="formSubmit">
            <div class="form-group">
              <label for="name">Organization Name</label>
              <input v-model="organization.name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" aria-describedby="name" placeholder="Enter organization name" required>
              <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input v-model="organization.email" type="text" class="form-control" :class="{'is-invalid' : errors.email}" aria-describedby="email" placeholder="Enter email">
              <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="organization.password" type="password" class="form-control" :class="{'is-invalid' : errors.password}" placeholder="Password" required>
              <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group">
              <label for="password_confirm">Confirm Password</label>
              <input v-model="organization.password_confirmation" :class="{'is-invalid' : errors.password}" type="password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
              <label for="subscription_id">Subscription Level</label>
              <select v-model="organization.subscription_id" name="subscription_id" class="form-control" required>
                <option value="1">Full School Site License</option>
                <option value="2">Classroom</option>
              </select>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
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
      organization: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        subscription_id: ''
      },
      errors: []
    };
  },
  methods: {
    formSubmit(e) {
      const router = this.$router;
      e.preventDefault();
      let user = this
      axios.post('/organizations', {
          name: this.organization.name,
          email: this.organization.email,
          password: this.organization.password,
          password_confirmation: this.organization.password_confirmation,
          subscription_id: this.organization.subscription_id
        })
        .then(function(response) {
          router.push({ path: '/admin/users' })
        })
        .catch(errors => {
          this.errors = errors.response.data.errors
        });
    }
  }
}
</script>

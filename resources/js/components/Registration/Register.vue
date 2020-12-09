<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <router-link to="/admin/users"><i class="fas fa-arrow-left"></i></router-link> Register New Organization</div>
        <div class="card-body">
          <form @submit="formSubmit">
            <div class="form-group">
              <label for="name">Name</label>
              <input v-model="user.name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" aria-describedby="name" placeholder="Enter username" required>
              <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
            </div>
            <div class="form-group">
              <label for="email">Email address</label>
              <input v-model="user.email" type="text" class="form-control" :class="{'is-invalid' : errors.email}" aria-describedby="email" placeholder="Enter email">
              <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input v-model="user.password" type="password" class="form-control" :class="{'is-invalid' : errors.password}" placeholder="Password" required>
              <small v-if="errors.password" class="text-danger">{{ errors.password[0] }}</small>
            </div>
            <div class="form-group">
              <label for="password_confirm">Confirm Password</label>
              <input v-model="user.password_confirmation" :class="{'is-invalid' : errors.password}" type="password" class="form-control" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
              <label for="password_confirm">Confirm Password</label>
              <input v-model="access_code" :class="disabled" type="password" class="form-control" placeholder="Confirm Password" required>
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
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      },
      access_code: this.$route.params.access_code,
      guard: this.$route.params.guard,
      errors: {}
    };
  },
  mounted() {

  }
}
</script>

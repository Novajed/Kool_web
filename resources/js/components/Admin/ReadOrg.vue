<template>
  <div class="container">
    <div class="card">
      <div class="card-header">
        <router-link to="/admin/users"><i class="fas fa-arrow-left"></i></router-link> {{ user.name }}
      </div>
      <ul v-if="loading" class="list-group list-group-flush">
        <li class="list-group-item"><strong>Loading...</strong> </li>
      </ul>
      <ul v-else class="list-group list-group-flush">
        <li class="list-group-item"><strong>Email:</strong> {{ user.email }}</li>
        <li class="list-group-item"><strong>Access Code:</strong> {{ user.id }}</li>
        <li class="list-group-item"><strong>Status</strong> {{ user.is_active ? 'Active' : 'Inactive' }}</li>
        <li class="list-group-item"><strong>Subscription Level:</strong> {{ user.subscription_id === 2 ? 'Classroom' : 'Full School Site License'}}</li>
      </ul>
    </div>
    <button type="button" class="btn btn-info" @click="editModal">Edit</button>
    <button type="button" class="btn btn-danger" @click="deleteOrg">Delete</button>
    <!--MODAL -->
    <div class="modal" id="editModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Organization</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-if="updated" class="alert alert-success small-blur" role="alert">
              Your changes has been saved!
            </div>
            <form>
              <div class="form-group">
                <label for="name">Organization Name</label>
                <input v-model="user.name" type="text" class="form-control" :class="{'is-invalid' : errors.name}" aria-describedby="name" placeholder="Enter organization name" required>
                <small v-if="errors.name" class="text-danger">{{ errors.name[0] }}</small>
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input v-model="user.email" type="text" class="form-control" :class="{'is-invalid' : errors.email}" aria-describedby="email" placeholder="Enter email">
                <small v-if="errors.email" class="text-danger">{{ errors.email[0] }}</small>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" @click="editOrg">Save changes</button>
          </div>
        </div>
      </div>
    </div>
    <!--MODAL -->
  </div>
</template>

<script>
export default {
  mounted() {
    this.$Progress.start()
    this.getUser()
    this.$Progress.finish()
  },
  data() {
    return {
      url: '/organizations/' + this.$route.params.id,
      user: {
        id: this.$route.params.id,
        email: '',
        name: ''
      },
      loading: true,
      errors: [],
      updated: false
    };
  },
  methods: {
    getUser() {
      let $this = this
      axios.get(this.url)
        .then(response => {
          this.user = response.data
          this.loading = false
        });
    },
    editModal() {
      this.updated = false
      $('#editModal').modal('show');
    },
    editOrg() {
      axios.put(this.url, this.user).then(
        this.updated = true
      ).catch(error => console.log(error));
    },
    deleteOrg() {
      const router = this.$router;
      if (confirm('are you sure?')) {
        axios.delete(this.url).then(
          router.push({ path: '/admin/users' })
        );
      }

    }

  }
}
</script>

<style>
.small-blur {
  opacity: 0.9;
}
</style>

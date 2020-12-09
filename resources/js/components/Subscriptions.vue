<template>
  <div>
    <div class="card">
      <div class="card-header">Subscriptions</div>
      <div class="card-body">
        <router-link class="nav-link" to="/subscriptions/package-1">Full School Site License</router-link>
        <router-link class="nav-link" to="/subscriptions/package-2">Classroom Subscription</router-link>
      </div>
    </div>
    <access-input></access-input>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component Mounted')
  }
}
</script>

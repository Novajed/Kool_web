<template>
  <div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header"><a href="javascript:void(0)" @click="back"><i class="fas fa-arrow-left"></i></a>Grade {{grade}}</div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <router-link class="grade-link" :to="{path: '/grade/'+grade+'/subject/2'}">
                  <div class="text-center grade-button">Math</div>
                </router-link>
              </div>
              <div class="col-md-6">
                <router-link class="grade-link" :to="{path: '/grade/'+grade+'/subject/1'}">
                  <div class="text-center grade-button">ELA</div>
                </router-link>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <router-link class="grade-link" :to="{path: '/grade/'+grade+'/subject/4'}">
                  <div class="text-center grade-button">Social Studies</div>
                </router-link>
              </div>
              <div class="col-md-6">
                <router-link class="grade-link" :to="{path: '/grade/'+grade+'/subject/3'}">
                  <div class="text-center grade-button">Science</div>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['grade'],
  methods: {
    back() {
      this.$router.go(-1)
    }
  }
}
</script>

<style>
.dev {
  background-color: #FEFEFE;
  border: 1px solid #000;
}
</style>

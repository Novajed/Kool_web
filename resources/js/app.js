
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue')
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'

const options = {
  color: '#00E676',
  failedColor: '#874b4b',
  thickness: '2px',
  transition: {
    speed: '1.5s',
    opacity: '0.6s',
    termination: 400
  },
  autoRevert: true,
  location: 'left',
  inverse: false
}

Vue.use(VueProgressBar, options)

Vue.use(VueRouter)
	

const routes = [
	{path:'/home',component: require('./components/views/Home.vue').default},
  {path:'/admin/home',component: require('./components/views/Home.vue').default},
  {path:'/portal/home',component: require('./components/views/Home.vue').default},
  {path:'/club/home',component: require('./components/views/Home.vue').default},
  {path:'/admin/users',component: require('./components/Admin/Organizations.vue').default,name: 'admin.users'},
  {path:'/admin/user/:id',component: require('./components/Admin/ReadOrg.vue').default},
  {path:'/admin/organization/store',component: require('./components/Admin/CreateOrg.vue').default},
  {path:'/admin/songs/create',component: require('./components/Admin/AddSong.vue').default},
	{path:'/users',component: require('./components/UserList.vue').default,meta: {
      progress: {
        func: [
          {call: 'color', modifier: 'temp', argument: '#00E676'},
          {call: 'fail', modifier: 'temp', argument: '#6e0000'},
          {call: 'location', modifier: 'temp', argument: 'top'},
          {call: 'transition', modifier: 'temp', argument: {speed: '1.5s', opacity: '0.6s', termination: 600}}
        ]
      }
    }},
	{path:'/subscriptions',component:require('./components/Subscriptions.vue').default},
	{path:'/subscriptions/package-1',component:require('./components/Subscriptions/package-1').default},
	{path:'/subscriptions/package-2',component:require('./components/Subscriptions/package-2').default},
  {path:'/registration/:guard/organization/:access_code', component: require('./components/Registration/Register.vue').default},
  {path:'/grade/:grade/', component: require('./components/views/SubjectsPage.vue').default},
  {path:'/grade/:grade/subject/:subject', component: require('./components/App/ListSongs.vue').default},
  {path:'/video/:video_id', component: require('./components/views/VideoPage.vue').default},
  {path:'/user/:user_id/playlists/', component: require('./components/views/PlaylistsPage.vue').default},
  {path:'/playlist/:playlist_id', component: require('./components/App/Playlist.vue').default},
  {path:'/portal/classrooms', component: require('./components/App/Classrooms/TeacherClassrooms.vue').default},
  {path:'/portal/classrooms/create', component: require('./components/App/Classrooms/Create.vue').default},
  {path:'/portal/classrooms/:classroom_id', component: require('./components/App/Classrooms/TeacherClassroom.vue').default},
  {path:'/portal/welcome',component: require('./components/Instructor/Welcome.vue').default},
  {path:'/student/classrooms',component: require('./components/views/Student/ClassroomsPage.vue').default}





	
]

const router = new VueRouter({
	mode:'history',
	routes
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('user-list', require('./components/UserList.vue').default);
Vue.component('subscriptions', require('./components/Subscriptions.vue').default);
Vue.component('access-input', require('./components/AccessInput.vue').default);
Vue.component('subjects', require('./components/App/Subjects.vue').default);
Vue.component('grades', require('./components/App/Grades.vue').default);
Vue.component('video-player', require('./components/App/Video.vue').default);
Vue.component('loading-screen',require('./components/App/Loading.vue').default);
Vue.component('pagination', require('./components/App/Pagination.vue').default);
Vue.component('add-students', require('./components/App/Classrooms/AddStudentModal.vue').default);
Vue.component('add-playlist', require('./components/App/Classrooms/AddPlaylistModal.vue').default);
Vue.component('classrooms', require('./components/App/Classrooms.vue').default);
Vue.component('classrooms-widget', require('./components/Widgets/Classrooms.vue').default);
Vue.component('search', require('./components/App/Search.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data:{
      user:{}
    },
    mounted(){
      this.userData()
    },
    created () {
    //  hook the progress bar to start before we move router-view
    this.$router.beforeEach((to, from, next) => {
      //  does the page we want to go to have a meta.progress object
      if (to.meta.progress !== undefined) {
        let meta = to.meta.progress
        // parse meta tags
        this.$Progress.parseMeta(meta)
      //  start the progress bar
      this.$Progress.start()
      }
      //  continue to next page
      next()
    })
    //  hook the progress bar to finish after we've finished moving router-view
    this.$router.afterEach((to, from) => {
      //  finish the progress bar
      this.$Progress.finish()
    })
  },
    router
}).$mount('#app')

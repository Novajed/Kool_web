<template>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <router-link to="/admin/home"><i class="fas fa-arrow-left"></i></router-link>Add New Song</div>
        <div v-if="message" class="alert alert-success" role="alert">
          {{ message }}
        </div>
        <div class="card-body">
          <form @submit="formSubmit">
            <div class="form-group">
              <label for="title">Title</label>
              <input v-model="song.title" type="text" class="form-control" aria-describedby="name" placeholder="Enter song title" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input v-model="song.description" type="text" class="form-control" aria-describedby="description" placeholder="Enter song description">
            </div>
            <div class="form-group">
              <label for="standard">Standard</label>
              <input v-model="song.standard" type="text" class="form-control" placeholder="Standard" required>
            </div>
            <div class="form-group">
              <label for="week">Week</label>
              <input v-model="song.week" type="text" class="form-control" placeholder="Week" required>
            </div>
            <div class="form-group">
              <label for="tags">Tags</label>
              <input v-model="song.tags" type="textarea" class="form-control" placeholder="Seperate by comma" required>
            </div>
            <div class="form-group">
              <label for="src">File Link</label>
              <input v-model="song.src" type="textarea" class="form-control" placeholder="Link to video">
            </div>
            <div class="form-group">
              <label for="grades">Select Grades</label>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.kinder" class="form-check-input" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">K</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.one" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1">
                <label class="form-check-label" for="inlineCheckbox1">1</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.two" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="2">
                <label class="form-check-label" for="inlineCheckbox1">2</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.three" class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                <label class="form-check-label" for="inlineCheckbox2">3</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.four" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="4">
                <label class="form-check-label" for="inlineCheckbox1">4</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.five" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="5">
                <label class="form-check-label" for="inlineCheckbox1">5</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.six" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="6">
                <label class="form-check-label" for="inlineCheckbox1">6</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.seven" class="form-check-input" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">7</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.eight" class="form-check-input" type="checkbox" id="inlineCheckbox1">
                <label class="form-check-label" for="inlineCheckbox1">8</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.nine" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="9">
                <label class="form-check-label" for="inlineCheckbox1">9</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.ten" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="10">
                <label class="form-check-label" for="inlineCheckbox1">10</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.eleven" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="11">
                <label class="form-check-label" for="inlineCheckbox1">11</label>
              </div>
              <div class="form-check form-check-inline">
                <input v-model="song.grades.twelve" class="form-check-input" type="checkbox" id="inlineCheckbox1" value="12">
                <label class="form-check-label" for="inlineCheckbox1">12</label>
              </div>
            </div>
            <div class="form-group">
              <label for="subject_id">Subject</label>
              <select v-model="song.subject_id" name="subject_id" class="form-control" required>
                <option value="1">ELA</option>
                <option value="2">Math</option>
                <option value="3">Science</option>
                <option value="3">Social Studies</option>
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
      song: {
        title: '',
        description: '',
        standard: '',
        week: '',
        tags: '',
        subject_id: '',
        grades: {},
        src: '',
        thumbnail_src: '',
      },
      file: '',
      message: false,
      errors: []
    }
  },
  methods: {
    formSubmit(e) {
      e.preventDefault();
      let $this = this;
      axios.post('/songs', {
        title: this.song.title,
        description: this.song.description,
        standard: this.song.standard,
        week: this.song.week,
        tags: this.song.tags,
        grades: this.song.grades,
        subject_id: this.song.subject_id,
        src: this.song.src,
        thumbnail_src: this.song.thumbnail_src,
        file: this.song.file
      }).then(function(response) {
        $this.message = response.data.message

      }).catch(errors => $this.errors = errors);
      window.scrollTo(0, 0)
    },
    uploadFile() {
      this.file = this.$refs.file.files[0]
    }
  }



}
</script>

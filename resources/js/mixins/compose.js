import axios from 'axios'

export default {
  data () {
    return {
      form: {
        body: '',
        media: []
      },

      media: {
        images: [],
        video: null,
        progress: 0
      },

      mediaTypes: {}//elti array er jonno [],but multiple array er jonno {}
    }
  },

  methods: {
    async submit () {
      if (this.media.images.length || this.media.video) {
        let media = await this.uploadMedia()//thakle upload.na thakle na
        this.form.media = media.data.data.map(r => r.id)//eta pre tweet controller a pathano hoyeche
      }
      await this.post()//eta image er sathe caption upload korbe.eta ekta method dectare korche

      this.form.body = ''
      this.form.media = []
      this.media.video = null
      this.media.images = []
      this.media.progress = 0
    },

    handleUploadProgress (event) {//onUploadProgress er pore created.ei eventi auto hoy
      this.media.progress = parseInt(Math.round((event.loaded / event.total) * 100))
    },

    async uploadMedia () {
      return await axios.post('/api/media', this.buildMediaForm(), {//post a reqst data pathanor jonno **this.buildMediaForm()
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: this.handleUploadProgress//its for a method declare and create
      })
    },

    buildMediaForm () {
      let form = new FormData()

      if (this.media.images.length) {
        this.media.images.forEach((image, index) => {
          form.append(`media[${index}]`, image)
        })
      }

      if (this.media.video) {
        form.append('media[0]', this.media.video)//???????????????????????????????????????????

      }
      return form
    },

    removeVideo () {
      this.media.video = null
    },

    removeImage (image) {
      this.media.images = this.media.images.filter((i) => {
        return image !== i
      })
    },

    async getMediaTypes () {
      let response = await axios.get('/api/media/types')

      this.mediaTypes = response.data.data
    //   console.log(response)
    },

    handleMediaSelected (files) {//img or video select er por eta
      Array.from(files).slice(0, 4).forEach((file) => {
        if (this.mediaTypes.image.includes(file.type)) {
          this.media.images.push(file)//console.log korle only name,type dekha jay
        }

        if (this.mediaTypes.video.includes(file.type)) {
          this.media.video = file//array noy tai push kora lage ni.console.log korle name,type dekha jay
          console.log(file)
        }
      })

      if (this.media.video) {
        this.media.images = []
      }
    //   console.log( this.media)
    //   console.log(  this.media.video)

    }
  },

  mounted () {
    this.getMediaTypes()
  }
}

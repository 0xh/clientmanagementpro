import guards from './../../mixins/guard'

Vue.component('uploaded-files', {
    mixins: [guards],
    props: ['tenant', 'guard'],
    data () {
        return {
            files: [],
            current_file: null,
            fileEditForm: new EvolutlyForm(Evolutly.forms.fileEditForm)
        }
    },

    mounted() {
        this.fetchUploadedFiles()
    },
    computed: {
        
    },
    methods: { 
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        },
        fileChunks(files) {
            return _.chunk(files, 3)
        },
        getSourceFile(file) {
            return `${window.location.protocol}//${Evolutly.domain}/${file.path}/${file.filename}.${file.extension}`
        },
        getImageByExtension(file) {
            let images = ['png','jpeg','gif','bmp', 'tiff','exif']
            let pdf = ['pdf','epub','mobi']
            let docs = ['doc','dot','docx','dotx','odt']
            let xls = ['xls','xlt','xla', 'xlsx', 'xltx', 'xlsm', 'xltm', 'xlam', 'xlsb']
            let ppt = ['ppt','pot','pps','ppa','pptx','potx','ppsx','ppam','pptm','potm','ppsm']
            let psd = ['psd']
            if(_.includes(images,file.extension)){
                return `/${file.path}/${file.filename}.${file.extension}`
            }else if(_.includes(pdf,file.extension)){
                return 'https://visual-integrity.com/wp-content/uploads/2016/02/pdf-page.png'
            }else if(_.includes(docs,file.extension)){
                return 'https://davescomputertips.com/wp-content/uploads/2014/03/microsoft-word-logo.jpg'
            } else if(_.includes(xls,file.extension)){
                return  'https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Microsoft_Excel_2013_logo.svg/2000px-Microsoft_Excel_2013_logo.svg.png'
            }else if(_.includes(ppt,file.extension)){
                return 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b0/Microsoft_PowerPoint_2013_logo.svg/1043px-Microsoft_PowerPoint_2013_logo.svg.png'
            }else if(_.includes(psd,file.extension)){
              return  'https://blogsimages.adobe.com/conversations/files/2012/03/Photoshop-CS6-Icon.jpg'
            }
                return 'http://4vector.com/i/free-vector-text-file-icon_101919_Text_File_Icon.png'

        },
        fetchUploadedFiles(){
            let pathArray = window.location.pathname.split( '/' );
            let projectID = null
            let self = this
            if(this.guard === 'web'){
            projectID = pathArray[3];
            axios.get('/files/show/'+ projectID).then((response) => {
                self.files = response.data
            }) 
            }else if(this.guard === 'employee'){
            projectID = pathArray[4];
            axios.get('/team/files/show/'+ projectID).then((response) => {
                self.files = response.data
            })
            }else if(this.guard === 'client'){
            projectID = pathArray[4];
            axios.get('/client/files/show/'+ projectID).then((response) => {
                self.files = response.data
            })
            }
             
        },
        showDeleteFileModal(file){
            let self = this
            self.current_file = file
            self.show(`delete-file-modal`)
        },
        closeDeleteFileModal(){
            let self = this
            self.hide(`delete-file-modal`)
            self.current_file = null
        },
        deleteFile(){
            let self = this
            self.guardAllowed(['web'],self.callApiDeleteFile(self.current_file))
        },
        callApiDeleteFile(file){
            let self = this
            self.endpoints.web = `/files/delete/${file.id}`
            axios.delete(self.guardedLocation()).then((response) => {
                let index = _.findIndex(self.files, { id: file.id })
                self.$delete(self.files, index)
                self.closeDeleteFileModal()
            }).catch(error => {
                self.closeDeleteFileModal()
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        showEditFileModal(file){
            let self = this
            self.current_file = file
            self.fileEditForm.name = file.name
            self.show(`edit-file-modal`)
        },
        closeEditFileModal(){
            let self = this
            self.hide(`edit-file-modal`)
            self.current_file = null
            self.fileEditForm = new EvolutlyForm(Evolutly.forms.fileEditForm)
        },
        editFile(){
            let self = this
            self.fileEditForm.busy = true
            self.endpoints.web = `/files/edit/${self.current_file.id}`
            axios.put(self.guardedLocation(),self.fileEditForm).then((response) => {
                let index = _.findIndex(self.files, { id: self.current_file.id })
                self.files[index].name = self.fileEditForm.name
                self.fileEditForm.busy = false
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                self.closeEditFileModal()
            }).catch(error => {
                self.fileEditForm.errors.set(error.response.data.errors)
                self.fileEditForm.busy = false
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
    }
});

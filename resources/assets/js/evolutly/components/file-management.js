import guards from './../../mixins/guard'

Vue.component('file-management', {
    mixins: [guards],
    props: ['files', 'tenant', 'guard'],
    data () {
        return {
            fileForm: new EvolutlyForm(EvolutlyForm.fileForm),
        }
    },

    mounted() {
        console.log('file management component loaded!')
    },
    computed: {
        
    },
    methods: { 
        fileChunks(files) {
            return _.chunk(files, 3)
        },
        getSourceFile(file) {
            return `${file.path}${file.filename}.${file.extension}`
        },
        getImageByExtension(file) {
            let images = ['png','jpeg','gif','bmp', 'tiff','exif']
            let pdf = ['pdf','epub','mobi']
            let docs = ['doc','dot','docx','dotx','odt']
            let xls = ['xls','xlt','xla', 'xlsx', 'xltx', 'xlsm', 'xltm', 'xlam', 'xlsb']
            let ppt = ['ppt','pot','pps','ppa','pptx','potx','ppsx','ppam','pptm','potm','ppsm']
            let psd = ['psd']
            if(_.includes(images,file.extension)){
                return `${file.path}${file.filename}.${file.extension}`
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
        editFile(file){
            console.log('file edited', file)
        },
        deleteFile(file){
            console.log('file deleted', file)
            let self = this
            self.guardAllowed(['web'],self.callApiDeleteFile(file))
        },
        callApiDeleteFile(file){
            let self = this
            self.endpoints.web = `/files/delete/${file.id}`
            axios.delete(self.guardedLocation()).then((response) => {
                console.log(response)
            })
        }
    }
});

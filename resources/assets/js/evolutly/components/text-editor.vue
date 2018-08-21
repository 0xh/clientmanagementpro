<template>
  <div>
    <trumbowyg :config="configs.advanced" v-model="content"></trumbowyg>
  </div>
</template>

<script>  
import trumbowyg from 'vue-trumbowyg'
import guards from './../../mixins/guard'
import 'trumbowyg/dist/plugins/colors/trumbowyg.colors'
import '../../plugins/trumbowyg.upload'
import 'trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.css'
export default {
mixins: [guards],
props:['description'],
data () {
    return {
    content: '',
    editForm: new EvolutlyForm(Evolutly.forms.editForm),
    trumbowyg: null,
    modal: null,
    configs: {
          advanced: {
            autogrow: true,
            removeformatPasted: true,
            // Adding color plugin button
            // Limit toolbar buttons
            btns: [
                ['viewHTML'],
                ['formatting'],
                'btnGrp-semantic',
                ['superscript', 'subscript'],
                ['link'],
                ['btnGrp-image'],
                'btnGrp-justify',
                'btnGrp-lists',
                ['horizontalRule'],
                ['foreColor'], ['backColor'],
                ['removeformat'],
                ['fullscreen'],
            ],
            btnsDef: {
            // Create a new dropdown
            'btnGrp-image': {
            dropdown: ['insertImage','upload'],
            ico: 'insertImage'
            }   
            },
          },
        }
        
        


    }
},
mounted () {
    let self = this
    self.content = self.description

    Bus.$on('upload-file',({data, trumbowyg, $modal, values} = payload) => {
        self.trumbowyg = trumbowyg
        self.modal = $modal
        self.uploadImage(data)
    })

    Bus.$on('editDescription',(id) => {
        self.callApiUpdateTask(id)
    })
},
methods: {
    uploadImage(formData){
        let self = this
        let current_url = $(location).attr('href').split("/").splice(0, 6).join("/");
        let segments = current_url.split( '/' );
        let jobId = segments[5];
        self.endpoints.web = `/files/upload/jobs/${jobId}`
        axios.post(self.guardedLocation(),formData).then((response) => {
        self.trumbowyg.execCmd('insertImage', response.data.url);
        $('img[src="' + response.data.url + '"]:not([alt])', trumbowyg.$box).attr('alt', response.data.description);
        self.trumbowyg.closeModal();
        self.trumbowyg.$c.trigger('tbwuploadsuccess', [self.trumbowyg, formData, response.data.url]);
        }).catch((error) => {
        self.$popup({ message: 'Failed To Upload Image', backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
        })
    },
    callApiUpdateTask(id){
            let self = this
            self.editForm.task_description = self.content
            self.endpoints.web = `/dashboard/jobs/${id}/edit/description`
            axios.put(self.guardedLocation(),self.editForm).then( (response) => { 
                Bus.$emit('updateDescription', self.content)
                Bus.$emit('closeEditor')
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            }).catch(error => {
                Bus.$emit('closeEditor')
                self.$popup({ message: error.response.data.errors.task_description[0], backgroundColor: '#e57373', delay: 5, color: '#fffffa', })
            })
        },
},
components: {
    trumbowyg
},
watch: {
    content: function(newVal, oldVal) {
    	console.log('value changed from ' + oldVal + ' to ' + newVal);
    }
}
}
</script>

import StarRating from 'vue-star-rating'
import guards from './../../mixins/guard'
import trumbowyg from 'vue-trumbowyg'
import 'trumbowyg/dist/plugins/colors/trumbowyg.colors'
import '../../plugins/trumbowyg.upload'
import 'trumbowyg/dist/plugins/colors/ui/trumbowyg.colors.css'

Vue.component('subtask', {
    mixins: [guards],
    props: ['guard','tenant','user','currentProject','currentWorkers', 'currentTask' ,'currentSubtask' ,'currentClient'],
    data () {
        return {
            subtask: {},
            project: {},
            task: {},
            client: {},
            options: [],
            subtaskForm: new EvolutlyForm(Evolutly.forms.editSubtaskForm),
            ratingForm: new EvolutlyForm(Evolutly.forms.ratingForm),
            rating: null,
            modal: null,
            trumbowyg: null,
            showEditor: false,
            configs: {
                advanced: {
                  autogrow: true,
                  removeformatPasted: true,
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
                  'btnGrp-image': {
                  dropdown: ['insertImage','upload'],
                  ico: 'insertImage'
                  }   
                  },
                },
              }

        }
    },
    create(){
        let self = this
        
    },
    mounted() {
        let self = this
        self.whenReady()
        self.assignSubtaskToForm()
        if(self.subtask.description == ''){
            self.showEditor = true
        }
        Bus.$on('upload-file',({data, trumbowyg, $modal, values} = payload) => {
            self.trumbowyg = trumbowyg
            self.modal = $modal
            self.uploadImage(data)
        })
    },
    computed: {
        employeeChunks() {
            let self = this
            return _.chunk(self.subtask.employees, 4)
        },
    },
    methods: {
        whenReady() {
            let self = this
            self.project =  self.currentProject
            self.subtask = self.currentSubtask
            self.task = self.currentTask
            self.client = self.currentClient
            self.options = self.currentWorkers
            
        },
        openEditor(){
            this.showEditor = true
        },
        closeEditor(){
            this.showEditor = false
        },
        assignSubtaskToForm(){
            let self = this
            self.subtaskForm.name = self.subtask.name
            self.subtaskForm.description = self.subtask.description
            self.subtaskForm.link = self.subtask.link
            self.subtaskForm.points = self.subtask.points 
            self.subtaskForm.priority = self.subtask.priority
            self.subtaskForm.done = self.subtask.done
            self.subtaskForm.due_date = moment(self.subtask.due_date).format('YYYY-MM-DD')
            self.subtaskForm.done = self.subtask.done
            self.subtaskForm.newCollaborator = false
            self.subtaskForm.assignedEmployees = self.subtask.employees
            self.subtaskForm.users = [{
                name: '',
                email: '',
                password: '',
            }]
            
            
        },
        uploadImage(formData){
            let self = this
            self.endpoints.web = `/files/upload/jobs/${self.task.id}`
            axios.post(self.guardedLocation(),formData).then((response) => {
            self.trumbowyg.execCmd('insertImage', response.data.url);
            $('img[src="' + response.data.url + '"]:not([alt])', trumbowyg.$box).attr('alt', response.data.description);
            self.trumbowyg.closeModal();
            self.trumbowyg.$c.trigger('tbwuploadsuccess', [self.trumbowyg, formData, response.data.url]);
            }).catch((error) => {
            self.$popup({ message: 'Failed To Upload Image', backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        goToTeam(){
            let self = this
            self.endpoints.web = `/users/teammates`
            self.guardAllowed(['web'],window.location.href = self.endpoints.web)
        },
        overDueDate(){
            let self = this
            if(self.subtask.done == false && self.subtask.due_date < moment(new Date).format('YYYY-MM-DD')){
                return true
            }
        },
        toggleDone(){
            let self = this
            self.guardAllowed(['web','employee'],self.callApiToggleSubtask())
        },
        callApiToggleSubtask(){
            let self = this
            self.endpoints.web = `/dashboard/jobs/${self.task.id}/tasks/${self.subtask.id}/toggle`
            self.endpoints.team = `/team/dashboard/jobs/${self.task.id}/tasks/${self.subtask.id}/toggle`
            axios.put(self.guardedLocation()).then((response) => {
                console.log(response.data.subtask)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
        },
        deleteSubtask(){
            var self = this
            self.guardAllowed(['web'],self.callApiDeleteSubtask())
        },
        callApiDeleteSubtask(){
            var self = this
            if(!self.subtaskForm.users[0]){
                delete self.subtaskForm.users
            }
            self.endpoints.web = `/dashboard/jobs/${self.task.id}/tasks/${self.subtask.id}/delete`
            axios.delete(self.guardedLocation())
            .then(function (response) {
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                window.location.href = `/dashboard/jobs/${self.task.id}/`
            })
            .catch(error => {
                if(!self.subtaskForm.users){
                    self.subtaskForm.users = [{
                        name: '',
                        email: '',
                        password: '',
                    }]
                }
                self.$popup({ message: _.first(error.response.data.message) })
            })
        },
        viewVideoLink(){
            let self = this
            window.open(self.subtask.link, '_blank');
        },
        setRating(rating){
            let self = this
            self.guardAllowed(['web'],self.rating = rating)
        },
        updateRating(newValue){
            let self = this
            self.ratingForm.subtask_priority = newValue
            self.subtaskForm.priority = newValue
            self.guardAllowed(['web'],self.callApiSetRatings(self.currentSubtask))
        },
        callApiSetRatings(){
            let self = this
            self.endpoints.web = `/dashboard/ratings/${self.subtask.id}`
            axios.put(self.guardedLocation(),self.ratingForm)
            .then((response) => {
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.ratingForm.errors.set(error.response.data.errors)
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        closeEditSubtask(){
            let self = this 
            self.hide('update-subtask-modal')
        },
        editTaskModal(){
            let self = this
            self.guardAllowed(['web'],self.show('update-subtask-modal'))
        },
        editSubtask(){
            let self = this
            self.guardAllowed(['web'],self.callApiEditSubtask())
            
        },
        editDescription(){
            let self = this
            if(self.subtask.description === ''){
                self.$popup({ message: 'PLEASE ADD DESCRIPTION', backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })  
                return
            }
            self.subtaskForm.description = self.subtask.description
            self.callApiEditSubtask()
        },
        callApiEditSubtask(){
            let self = this
            self.subtaskForm.busy = true
            if(self.subtaskForm.link == null){
                delete self.subtaskForm.link
            }
            if(self.subtaskForm.description == null){
                delete self.subtaskForm.description
            }
            if(self.subtaskForm.name == null){
                delete self.subtaskForm.name
            }
            if(self.subtaskForm.points == null){
                delete self.subtaskForm.points
            }
            if(self.subtaskForm.priority == null){
                delete self.subtaskForm.priority
            }
            if(self.subtaskForm.due_date == null){
                delete self.subtaskForm.due_date
            }
            if(self.subtaskForm.newCollaborator == false){
                delete self.subtaskForm.users
            }
            if(!self.subtaskForm.assignedEmployees){
                delete self.subtaskForm.assignedEmployees
            }
            self.endpoints.web = `/dashboard/tasks/${self.subtask.id}/update`
            axios.put(self.guardedLocation(),self.subtaskForm)
            .then((response) => {
                self.subtask = response.data.subtask
                self.subtaskForm.resetStatus()
                self.subtaskForm.busy = false
                self.closeEditor()
                self.closeEditSubtask()
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                if(!self.subtaskForm.description){
                    self.subtaskForm.description = self.subtask.description
                }
                if(!self.subtaskForm.link){
                    self.subtaskForm.link = ''
                }
                if(!self.subtaskForm.name){
                    self.subtaskForm.name = ''
                }
                if(!self.subtaskForm.points){
                    self.subtaskForm.points = ''
                }
                if(!self.subtaskForm.priority){
                    self.subtaskForm.priority = ''
                }
                if(!self.subtaskForm.due_date){
                    self.subtaskForm.due_date = null
                }
                if(!self.subtaskForm.users){
                    [{
                        name: '',
                        email: '',
                        password: '',
                    }]
                }
                if(!self.subtask.employees){
                    self.subtask.employees = []
                }
                if(error.response.data.errors){
                self.subtaskForm.errors.set(error.response.data.errors)
                }
                self.subtaskForm.busy = false
                self.closeEditor()
                self.closeEditSubtask()
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
            })
        },
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        },
        updateAssignedEmployees(){
            let self = this
            self.subtaskForm.assignedEmployees = self.subtask.employees
            self.guardAllowed(['web'],self.callApiEditSubtask())
        },
        updateDescription(){
            let self = this
            self.subtaskForm.description = self.subtask.description
            self.guardAllowed(['web'],self.callApiEditSubtask())
        }
        
    },
    watch: {
        rating(newValue){
            this.updateRating(newValue)
        },
        priority(newValue){
            this.setPriority(newValue)
            this.subtaskForm.priority = newValue
        },
        subtask: {
            handler(newValue){
   
            },
            deep: true
        },
        options(newValue){
            console.log('workers updated!')
        }
    },
    
    components: {
        StarRating,
        trumbowyg
    }

})

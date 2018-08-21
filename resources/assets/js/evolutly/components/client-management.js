import guards from './../../mixins/guard'

Vue.component('client-management', {
    mixins: [guards],
    props:['user','clientlist', 'projectlist'],
    data () {
        return {
            clients: [],
            registerForm: new EvolutlyForm(Evolutly.forms.registerClientForm),
            current_client: null,
            current_index: null,
            current_project: null,
            current_project_index: null,
            projects: [],
            options: [],
        }
    },
    mounted() {
        this.clients = this.clientlist
        this.projects = this.projectlist
        if(this.projects.length == 0){
            this.registerForm.new_project = true
        }
        
    },
    methods:{
        show(name) {
             this.$modal.show(name)
        },
        hide(name) {
             this.$modal.hide(name)
        },
        showAddClientModal(){
            let self = this 
            self.resetRegisterForm()
            self.show('add-client-modal')
        },
        addClient(){
            let self = this
            self.guardAllowed(['web'],self.callAddClientApi())
        },
        closeAddClientModal(){
            let self = this
            self.resetRegisterForm()
            self.hide('add-client-modal')
        
        },
        resetCurrentClient(){
            let self = this
            self.current_client = null
            self.current_index = null
            self.current_project = null
            self.current_project_index = null
        },
        resetRegisterForm(){
            let self = this
            self.registerForm = new EvolutlyForm(Evolutly.forms.registerClientForm)
            self.registerForm.links = {
                facebook: '',
                linkedin: '',
                twitter: '',
                instagram: '',
                youtube: '',
                googleplus: '',
                website: ''
            }
        },
        fillRegisterForm(client){
            let self = this
            self.registerForm.name = client.name
            self.registerForm.first_name = client.first_name
            self.registerForm.last_name = client.last_name
            self.registerForm.phone = client.phone
            self.registerForm.address = client.address
            self.registerForm.address_line_2 = client.address_line_2
            self.registerForm.city = client.city
            self.registerForm.zip = client.zip
            self.registerForm.country = client.country
            self.registerForm.email = client.email
            self.registerForm.password = client.password
            self.registerForm.website = client.website ? client.website : ''
            self.registerForm.links = client.links ? client.links : {
                facebook: '',
                linkedin: '',
                twitter: '',
                instagram: '',
                youtube: '',
                googleplus: '',
                website: ''
            }
            self.registerForm.assignedProjects = client.projects
            this.options = _.union(this.projects, this.registerForm.assignedProjects) 
        },
        callAddClientApi(){
            let self = this
            self.endpoints.web = '/users/clients'
            if(!self.registerForm.new_project){
                delete self.registerForm.projects
            }
            axios.post(self.guardedLocation(), self.registerForm)
             .then((response) => {
                 self.registerForm.resetStatus()
                 self.resetRegisterForm()
                 self.clients.push(response.data.client)
                 self.projects = response.data.projectlist
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                 self.hide('add-client-modal')
             })
             .catch((error) => {
                if(!self.registerForm.new_project){
                    self.registerForm.projects = [{
                        name: '',
                    }]
                }
                 self.registerForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
            
        },
        showEditModal(client,clientKey){
            let self = this
            self.guardAllowed(['web'],self.fillRegisterForm(client))
            self.guardAllowed(['web'],self.show('edit-client-modal'))
            self.current_index = clientKey
            self.current_client = client
        },
        closeEditModal(){
            let self = this
            self.guardAllowed(self.resetRegisterForm())
            self.guardAllowed(['web'],self.hide('edit-client-modal'))
            self.resetCurrentClient()
        },
        editClient(){
            let self = this
            if(!self.registerForm.password){
                delete self.registerForm.password
                delete self.registerForm.password_confirmation
            }
            if(!self.registerForm.new_project){
                delete self.registerForm.projects
            }
            self.endpoints.web = `/users/clients/${self.current_client.id}/edit`
             axios.put(self.guardedLocation(), self.registerForm)
             .then((response) => {
                self.registerForm.resetStatus()
                 self.$set(self.clients, self.current_index, response.data.client)
                 this.projects = response.data.projectlist
                 this.options = _.union(this.projects, this.registerForm.assignedProjects)
                 self.closeEditModal()
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
             })
             .catch((error) => {
                if(!self.registerForm.password){
                    self.registerForm.password = ''
                }
                if(!self.registerForm.password_confirmation){
                    self.registerForm.password_confirmation = ''
                }
                if(!self.registerForm.projects){
                    self.registerForm.projects = [{
                        name: '',
                    }]
                }
                 self.registerForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
        },
        showDeleteModal(client,clientKey){
            let self = this
            self.current_client = client
            self.current_index = clientKey
            self.guardAllowed(['web'],self.show('delete-client-modal'))
            
        },
        closeDeleteModal(){
            let self = this
            self.resetCurrentClient()
            self.guardAllowed(['web'],self.hide('delete-client-modal'))
            
        },
        deleteClient(){
            let self = this
            self.endpoints.web = `/users/clients/${self.current_client.id}/delete`
            axios.delete(self.guardedLocation())
            .then(function (response) {
                self.clients.splice(self.current_index,1)
                self.resetCurrentClient()
                self.$popup({ message: `Client Has Been Deleted.`, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.hide('delete-client-modal')
            })
            .catch(error => {
                if(error.response.data.message){
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        deleteAllProjects(){
           
        },
        unassigneProject(){
            
        },
        viewProject(id) {
            window.open(`/dashboard/clients/${id}`)
        },
        newProjectInput(){
            this.registerForm.projects.push({
                name: '',
                email: '',
                password: ''
            })
        },
        removeProjectInput(index){
            this.registerForm.projects.splice(index,1)
        }
     }
});

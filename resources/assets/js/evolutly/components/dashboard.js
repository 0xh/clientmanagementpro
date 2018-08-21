import guards from './../../mixins/guard'

Vue.component('dashboard', {
    mixins: [guards],
    props: ['guard', 'tenant', 'user', 'projectlist' ,'clientlist'],
    data () {
        return {
            campaigns: [],
            projectForm: new EvolutlyForm(Evolutly.forms.projectForm),
            editProjectForm: new EvolutlyForm(Evolutly.forms.editProjectForm),
            cloneForm: new EvolutlyForm(Evolutly.forms.cloneForm),
            styling: {
                clearBottom: false,
            },
            clients: [],
            current_project: null,
            current_index: null,
            projects: [],
            current_project: null
        }
    },

    mounted() {
        this.clients = this.clientlist
        this.projects = this.projectlist
    },
    computed: {
        hasNoProject(){
            if(this.projects.length < 4){
                this.styling.clearBottom = true
            }
        }
    },

    methods: { 
        updateProjectName(){
            let self = this 
            self.editProjectForm.busy = true
            
            self.endpoints.web = `/dashboard/clients/${self.current_project.id}/edit`
            if(self.editProjectForm.newclient){
                delete self.editProjectForm.client_id
            }else {
                delete self.editProjectForm.client
            }
            delete self.editProjectForm.id
                axios.post(self.guardedLocation(), self.editProjectForm)
                .then(function (response) {
                    self.closeEditProjectModal()
                    let index = _.findIndex(self.projects, { id: self.current_project.id })
                    // add a re-order function to reorder the campaigns
                    self.$set(self.projects, index, response.data.project)
                    self.clients = response.data.clients
                    self.resetProjectForm()
                    self.editProjectForm.client_id = _.find(this.clients, { id: response.data.client })
                    self.editProjectForm.busy = false
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                })
                .catch(error => {
                    self.editProjectForm.errors.set(error.response.data.errors)
                    if(!self.editProjectForm.client_id){
                        self.editProjectForm.client_id = _.find(this.clients, { id: this.project.client_id })
                    }
                    if(!self.editProjectForm.client){
                        this.editProjectForm.client = {
                            name: '', 
                            email: '', 
                            password: ''
                        }
                    }
                    self.editProjectForm.busy = false
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                })
                
        },
        closeEditProjectModal(){
            this.editProjectForm = new EvolutlyForm(Evolutly.forms.editProjectForm)
            this.hide('edit-project')
        },
        fillUpEditProjectModal(project){
            let self = this 
            self.current_project = project
            self.editProjectForm.client_name =  project.name
            self.editProjectForm.id  = project.id
            self.editProjectForm.client_id = _.find(this.clients, { id: project.client_id })
        },
        showEditProjectModal(project){
            this.fillUpEditProjectModal(project)
            this.show('edit-project')
        },
        clonableHint(project){
            if(project.public === true){
                return 'Remove From Template'
            }else{
                return 'Add To Template'
            }
        },
        isClonable(project){
            return project.public === true
        },
        canCloneProject(project){
            let self = this
            if(self.guard === 'web' && project.tenant_id === self.user.id){
                return true
            }else if(self.guard === 'employee' && project.projectable_type === 'App\Employee' && project.projectable_id === self.user.id){
                return true
            }
            return false
        },
        resetProjectForm(){
            this.projectForm = new EvolutlyForm(Evolutly.forms.projectForm)
        },
        resetCloneForm(){
            this.cloneForm = new EvolutlyForm(Evolutly.forms.cloneForm)
        },
        clonableChunks(clonables){
            return _.chunk(clonables, 3)
        },
        projectChunks(projects) {
            return _.chunk(projects, 3)
        },
        campaignProgress(campaign)
        {
            if(campaign.total_points > 0)
            {
                return Math.floor((campaign.done_points / campaign.total_points) * 100);
            }
            return 0;
        },
        showCloneModal(project){
            let self = this 
            self.resetCloneForm()
            self.show('project-clone-modal')
            self.setCurrentProject(project)
        },
        setCurrentProject(project){
            let self = this
            self.current_project = project.id
        },
        closeCloneModal(){
            let self = this
            self.resetCloneForm()
            self.current_project = null
            self.hide('add-client-modal')
        },
        toggleClonable(index,project){
            let self = this
            self.guardAllowed(['web'],self.callToggleCloneApi(index,project))
        },
        callToggleCloneApi(index,project)
        {
            let self = this
            self.current_index = index
            self.endpoints.web = `/projects/${project.id}/toggleClonable`
            axios.post(self.guardedLocation())
            .then((response) => {
                // update the specific project index    
                self.$set(self.projects, self.current_index, response.data.project)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.current_index = null
            })
            .catch((error) => {
                if(response.data.message){
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Server Failed To Serve the Request.', backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', }) 
                }
            })
        },
        cloneProject()
        {
            let self = this
            
            self.guardAllowed(['web'],self.callCloneApi())
        },
        callCloneApi(){
            let self = this
            self.endpoints.web = `/clone/${self.current_project}`
            if(self.cloneForm.newclient){
                delete self.cloneForm.client_id
            }else {
                delete self.cloneForm.client
            }
            axios.post(self.guardedLocation(), self.cloneForm)
             .then((response) => {
                 self.cloneForm.resetStatus()
                 self.resetCloneForm()
                 self.projects.push(response.data.project)
                 self.clients = response.data.clients
                 self.cloneForm.client = {
                    name: '', 
                    email: '', 
                    password: '',
                    website: '',
                }
                self.current_project = null
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.hide('project-clone-modal')
             })
             .catch((error) => {
                if(!self.cloneForm.client_id){
                    self.cloneForm.client_id = ''
                }
                if(!self.cloneForm.client){
                    self.cloneForm.client = {
                        name: '', 
                        email: '', 
                        password: '',
                        website: '',
                    }
                }
                 self.cloneForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
        },
        createProject()
        {
            var  self = this
            self.projectForm.busy = true
            if(self.projectForm.newclient){
                delete self.projectForm.client_id
            }else {
                delete self.projectForm.client
            }
            if(self.guard === 'web')
            {
                let location = '/dashboard/clients/create'
                let url = `${window.location.protocol}//${Evolutly.domain}${location}`
                axios.post(url, self.projectForm)
                .then(function (response) {
                    self.$modal.hide('add-project');
                    self.projects.push(response.data.project)
                    self.clients = response.data.clients
                    self.resetProjectForm()
                    self.projectForm.client = {
                        name: '', 
                        email: '', 
                        password: ''
                    }
                    self.projectForm.busy = false
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                })
                .catch(error => {
                    if(!self.projectForm.client_id){
                        self.projectForm.client_id = ''
                    }
                    if(!self.projectForm.client){
                        self.projectForm.client = ''
                    }
                    self.projectForm.errors.set(error.response.data.errors)
                    self.projectForm.busy = false
                    self.$popup({ message: error.response.data.message })
                })
            }else{
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        deleteProject(id) {
            var self = this
            if (self.guard === 'web') {
                axios.post('/dashboard/clients/' + id + '/delete')
                    .then(function (response) {
                        let index = _.findIndex(self.projects, { id: id })
                        self.$delete(self.projects, index)
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        self.projectForm.client_name = response.data.project
                        self.projectForm.client_name = ''
                    })
                    .catch(error => {
                        self.$popup({ message: _.first(error.response.data.campaign_name) })
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
            
        },
        viewProject(id) {
            let location = '/dashboard/clients/'+id
            if (this.guard === 'employee') {
                location = '/team/dashboard/clients/'+id
            }else if(this.guard === 'client'){
                location = '/client/dashboard/clients/'+id
            }
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`
            console.log(url)
            window.location.href = url
        },
        viewProgress(id,name) {
            let location = '/dashboard/clients/' + id + '/progress'
            if (this.guard === 'employee') {
                location = '/team/dashboard/clients/'+id + '/progress'
            }else if(this.guard === 'client'){
                location = '/client/dashboard/clients/'+id + '/progress'
            }
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`
            this.campaigns = [];
            // load a loader circle
            axios.post(url).then(function (response) {
                this.campaigns = response.data
                this.$modal.show(name);
            }.bind(this))
        },
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        },
        goToTemplates(){
            let location = '/templates'
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`
            window.location.href = url
        }
    },
    watch: {
        projects: {
            handler(newValue){
            },
            deep: true
          }
    },
});

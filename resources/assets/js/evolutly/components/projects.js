import FileUpload from 'vue-upload-component'

Vue.component('projects', {
    props: ['guard','clientlist', 'tenant','user', 'project', 'workers', 'campaignlist'],
    // extra props we might need to add : files and forms
    data () {
        return {
            projectForm: new EvolutlyForm(Evolutly.forms.projectForm),
            campaignForm: new EvolutlyForm(Evolutly.forms.campaignForm),
            campaignOrderForm: new EvolutlyForm(Evolutly.forms.campaignOrderForm),
            taskForm: new EvolutlyForm(Evolutly.forms.taskForm),
            formBuilderForm: new EvolutlyForm(Evolutly.forms.formBuilderForm),
            currentCampaignId: null,
            campaigns: [],
            oldCampaigns: null,

            // all about files
            fileForm: new EvolutlyForm(Evolutly.forms.fileForm),
            files: [],
            accept: 'image/png,image/gif,image/jpeg,image/webp,image/bmp,image/vnd.adobe.photoshop,application/pdf,application/vnd.openxmlformats-officedocument.presentationml.presentation,application/vnd.ms-powerpoint,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.wordprocessingml.template,application/vnd.ms-excel,text/plain,application/vnd.oasis.opendocument.text',
            size: 1024 * 1024 * 10,
            extensions: 'gif,jpg,jpeg,png,webp,bmp,psd,pdf,ppt,pptx,doc,docx,dotx,xls,txt,odt',
            // extensions: ['gif', 'jpg', 'jpeg','png', 'webp'],
            // extensions: /\.(gif|jpe?g|png|webp)$/i,
            multiple: true,
            directory: false,
            drop: true,
            dropDirectory: false,
            thread: 3,
            name: 'file',
            postAction: `${window.location.protocol}//${Evolutly.domain}/files/upload/${this.project.id}`,
            headers: {
                "X-Csrf-Token": Evolutly.csrfToken,
            },
            data: {
                "_csrf_token": Evolutly.csrfToken,
            },
            auto: false,
            draggableOptions: {
                group: 'campaign',
                handle: '.draghandle',
                filter: '.v--modal-box,.v--modal',
                scroll: true,
                preventOnFilter: false, 
                disabled: (this.guard === 'web' ? false : true)
            },
            moveable: (this.guard === 'web' ? 'move' : 'initial'),
            from: {
                index: null,
                id: null,
                chunk: null,
                key: null,
                order: null
            },
            to: {
                index: null,
                id: null,
                chunk: null,
                key: null,
                order: null
            },
            clients:[]
        }
    },
    mounted() {
        this.whenReady()
        this.campaigns = this.campaignlist
    },
    computed: {
        
        employeeChunks() {
            return _.chunk(this.workers, 4)
        },
        hasFiles()
        {
            if(this.files.length > 0)
            {
                return true
            }
        },
        noFile()
        {
            if(this.files.length == 0)
            {
                return true
            }
        },
    },
    methods: {

        whenReady() {
            this.clients = this.clientlist
            this.projectForm.client_name = this.project.name
            this.projectForm.client_id = _.find(this.clients, { id: this.project.client_id })
        },
        resetProjectForm(){
            this.projectForm = new EvolutlyForm(Evolutly.forms.projectForm)
            
        },
        isTaskDone(task){
            return task.done == 1;
        },
        campaignChunks(campaigns) {
            return _.chunk(campaigns, 2)
        },
        showTask(id) {
            this.currentCampaignId = id
            this.$modal.show('add-task')
        },
        hideTask() {
            this.currentCampaignId = null
            this.$modal.hide('add-task')
        },
        viewTask(id) {
            let location = '/dashboard/jobs/'
            if(this.guard==='employee')
            {
                location = '/team/dashboard/jobs/'
            }else if(this.guard==='client'){
                location = '/client/dashboard/jobs/'
            }
            let url = `${window.location.protocol}//${Evolutly.domain}${location}${id}`
            this.$popup({ message: 'Viewing Task', backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            window.location.href = url
        },
        createTask() {
            var self = this
            self.taskForm.busy = true
            let location = `/dashboard/campaigns/${self.currentCampaignId}/jobs/create`
            let url = `${window.location.protocol}//${Evolutly.domain}${location}`

            if (this.guard === 'web') {

                axios.post(url, self.taskForm).then(function (response) {
                    let index = _.findIndex(self.campaigns, { id: self.currentCampaignId })
                    self.campaigns[index].tasks.push(response.data.task)
                    // bug here
                    self.taskForm.resetStatus()
                    self.taskForm = new EvolutlyForm(Evolutly.forms.taskForm)
                    self.taskForm.busy = false
                    self.$popup({ message: response.data.message })
                })
                    .catch(error => {
                        self.taskForm.errors.set(error.response.data.errors)
                        self.taskForm.busy = false
                        self.$popup({ message: error.response.data.message })
                    })
            } else {
                self.taskForm.busy = false
                self.$popup({ message: 'Oops Cant Do That!' })
            }

        },
        updateProject(id) {
            var self = this
            self.projectForm.busy = true
            if(self.projectForm.newclient){
                delete self.projectForm.client_id
            }else {
                delete self.projectForm.client
            }
            if (this.guard === 'web') {
            axios.post('/dashboard/clients/' + id + '/edit', self.projectForm)
            .then(function (response) {
                self.$modal.hide('edit-project')
                self.clients = response.data.clients
                self.resetProjectForm()
                self.projectForm.client_id = response.data.client
                self.projectForm.client_name = response.data.project.name
                self.projectForm.busy = false
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.projectForm.errors.set(error.response.data.errors)
                if(!self.projectForm.client_id){
                    self.projectForm.client_id = _.find(this.clients, { id: this.project.client_id })
                }
                if(!self.projectForm.client){
                    this.projectForm.client = {
                        name: '', 
                        email: '', 
                        password: ''
                    }
                }
                self.projectForm.busy = false
                self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
            })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        showDeleteProjectModal(){
            var self = this
            self.show('delete-project-modal')
        },
        closeDeleteProjectModal(){
            var self = this
            self.hide('delete-project-modal')
        },
        deleteProject() {
            var self = this
            self.projectForm.busy = true
            if (this.guard === 'web') {
                axios.post('/dashboard/clients/' + self.project.id + '/delete')
                    .then(function (response) {
                        self.projectForm.busy = false
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        let location = '/dashboard'
                        let url = `${window.location.protocol}//${Evolutly.domain}${location}`
                        window.location.replace(url)
                    })
                    .catch(error => {
                        self.projectForm.busy = false
                        self.$popup({ message: _.first(error.response.data.campaign_name) })
                    })
            } else {
                self.projectForm.busy = false
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        resetCampaignForm(){
            var self = this
            let last_index = self.campaigns.length + 1
            self.campaignForm.campaign_order = last_index
            self.campaignForm.campaign_name = ''
        },
        showCampaignModal(){
            var self = this
            self.resetCampaignForm()
            self.show('add-campaign')
            
        },
        createCampaign() {
            var self = this
            self.campaignForm.busy = true
            if (this.guard === 'web') {
            
            axios.post('/dashboard/clients/' + self.project.id + '/campaigns/create', self.campaignForm)
            .then(function (response) {
                self.$modal.hide('add-campaign');
                let campaign = response.data.campaign
                campaign['tasks'] = [];
                self.campaigns.push(campaign)
                // add a re-order function to reorder the campaigns
                self.campaignForm.resetStatus()
                self.resetCampaignForm()
                self.campaignForm.busy = false
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
            })
            .catch(error => {
                self.campaignForm.busy = false
                self.$popup({ message: _.first(error.response.data.message) })
            })
            }else {
                self.campaignForm.busy = false
                self.$popup({ message: 'Oops Cant Do That!' })
            }
            
        },
        setCampaignFormFromCampaign(campaign){
            this.campaignForm.campaign_name = campaign.name
            this.campaignForm.campaign_order = campaign.order
        },
        editCampaignModal(campaign)
        {
            this.setCampaignFormFromCampaign(campaign)
            this.$modal.show('campaign-'+campaign.id)
        },
        //works like charm
        updateCampaign(campaign) {
            var self = this
            self.campaignForm.busy = true
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + campaign.id + '/edit', self.campaignForm)
                    .then(function (response) {
                        self.$modal.hide('campaign-'+ campaign.id)
                        let index = _.findIndex(self.campaigns, { id: campaign.id })
                        console.log(index)
                        // add a re-order function to reorder the campaigns
                        self.$set(self.campaigns, index, response.data.campaign)
                        self.campaignForm.resetStatus()
                        self.resetCampaignForm()
                        self.campaignForm.busy = false
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                    })
                    .catch(error => {
                        self.campaignForm.busy = false
                        self.campaignForm.errors.set(error.response.data.errors)
                        self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#4db6ac', })
                    })
            } else {
                self.campaignForm.busy = false
                self.$popup({ message: 'Oops Cant Do That!' })
            }
        },
        setFrom(e){
                this.from.index = e.oldIndex,
                this.from.id = e.target.getAttribute('data-id'),
                this.from.chunk = e.target.getAttribute('keyChunk'),
                this.from.key = e.target.getAttribute('cKey')
        },
        setTo(e){
                this.to.index = e.newIndex,
                this.to.id = e.item.offsetParent.getAttribute('data-id'),
                this.to.chunk = e.item.offsetParent.getAttribute('keyChunk'),
                this.to.key = e.item.offsetParent.getAttribute('cKey')
        },
        resetFromAndTo(){
            this.from = {
                index: null,
                id: null,
                chunk: null,
                key: null,
                order: null
            }
            this.to = {
                index: null,
                id: null,
                chunk: null,
                key: null,
                order: null
            }
        },
        onStart(e){
            let self = this
            self.setFrom(e)
            let campaign = self.getFromCampaign()
            self.from.order = campaign.order
            
        },
        onEnd(e){
            let self = this
            self.setTo(e)
            let campaign = self.getToCampaign()
            self.to.order = campaign.order
            self.switchCampaign(self.to.order,self.from.id)
        },
        getFromCampaign(){
            let self = this
            let index = _.findIndex(self.campaigns, function(o) { return o.id == self.from.id; })
            return self.campaigns[index]
        },
        getToCampaign(){
            let self = this
            let index = _.findIndex(self.campaigns, function(o) { return o.id == self.to.id; })
            return self.campaigns[index]
        },
        switchCampaign(order,id) {
            var self = this
            self.campaignOrderForm.campaign_order = parseInt(order)
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + id + '/reorder', self.campaignOrderForm)
                    .then(function (response) {
                        
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        return true;
                    })
                    .catch(error => {
                        self.$popup({ message: error.response.data.message })
                        return false;
                    })
            } else {
                self.$popup({ message: 'Oops Cant Do That!' })
                return false;
            }
        },
        showDeleteCampaignModal(id){
            let self = this
            self.show(`delete-campaign-modal-${id}`)
        },
        deleteCampaign(campaign) {
            var self = this
            self.campaignForm.busy = true
            if (this.guard === 'web') {
                axios.post('/dashboard/campaigns/' + campaign.id + '/delete')
                    .then(function (response) {
                        self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffc107', })
                        let index = _.findIndex(self.campaigns, { id: campaign.id })
                        self.$delete(self.campaigns, index)
                        // hack to rerender the dom
                        self.campaignForm.campaign_name = response.data.campaign.name
                        self.campaignForm.campaign_name = ''
                        self.campaignForm.campaign_order = 0
                        self.campaignForm.busy = false
                        self.hide(`delete-campaign-modal-${campaign.id}`)
                    })
                    .catch(error => {
                        self.campaignForm.busy = false
                        self.hide(`delete-campaign-modal-${campaign.id}`)
                        self.$popup({ message: 'Failed To Delete Campaign' })
                        
                    })
            } else {
                self.campaignForm.busy = false
                self.hide(`delete-campaign-modal-${campaign.id}`)
                self.$popup({ message: 'Oops Cant Do That!' })
                
            }
        },
        
        // Soon To Be Added
        createForm(id) {
            axios.post('dashboard/clients/'+id+'/forms/create', this.formBuilderForm)
            .then(function (response) {
                // we need to pass in the data
                // We need to add forms as props
                console.log('push this to forms array')
            }.bind(this))
            .catch(error => {
                console.log(error)
            })
        },
        show(name) {
            this.$modal.show(name)
        },
        hide(name) {
            this.$modal.hide(name)
        },
        uploadFile(project) {

            this.fileForm = document.getElementById('file').files[0]
            axios.post('dashboard/clients/' + project.id + '/files/upload', this.fileForm)
            .then(function (response) {
                console.log('push this to files array')
            })
            .catch(error => {
                console.log(error)
            })
        },
        addFiles(files) {
            this.files = files
        },
        addDirectory() {
            this.directory = true
            this.$nextTick(() => {
                this.$refs.upload.$el.querySelector('input').click()
                this.directory = false
            })
        },
        filter(file) {
            // min size
            if (file.size < 100 * 1024) {
                file = this.$refs.upload.update(file, { error: 'size' })
            }
            return file
        },
        inputFile(newFile, oldFile) {
            if (newFile && !oldFile) {
                console.log('add', newFile)
                var URL = window.URL || window.webkitURL
                if (URL && URL.createObjectURL) {
                    this.$refs.upload.update(newFile, { blob: URL.createObjectURL(newFile.file) })
                }
            }
            if (newFile && oldFile) {
                console.log('update', newFile, oldFile)
                if (newFile.progress != oldFile.progress) {
                    console.log('progress', newFile.progress)
                }
            }
            if (!newFile && oldFile) {
                console.log('remove', oldFile)
            }
            if (this.auto && !this.$refs.upload.uploaded && !this.$refs.upload.active) {
                this.$refs.upload.active = true
            }
        },
        abort(file) {
            this.$refs.upload.update(file, { active: false })
            // or
            // this.$refs.upload.update(file, {error: 'abort'})
        },
        customError(file) {
            this.$refs.upload.update(file, { error: 'custom' })
        },
        remove(file) {
            this.$refs.upload.remove(file)
        },
    },
    components: {
        FileUpload
    },
    watch: {
        auto(auto) {
            if (auto && !this.$refs.upload.uploaded && !this.$refs.upload.active) {
                this.$refs.upload.active = true
            }
        },
        campaigns: {
            handler(newValue){
            },
            deep: true
          }
    },

})

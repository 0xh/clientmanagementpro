import guards from './../../mixins/guard'
import campaignlist from './campaignlist.vue'
import mycampaignlist from './mycampaignlist.vue'

Vue.component('templates', {
    mixins: [guards],
    props: ['guard','templatelist', 'tenant','user', 'mytemplatelist'],
    data () {
        return {
            templates: [],
            current_index: null,
            mycurrent_index: null,
            current_template: null,
            mycurrent_template: null,
            current_campaign: null,
            mycurrent_campaign: null,
            mytemplates:[]
        }
    },
    mounted() {
        let self = this
        self.whenReady()
        Bus.$on('show-jobs-modal', (campaign) => {
            self.showJobs(campaign)
        })
        Bus.$on('show-myjobs-modal', (campaign) => {
            self.showJobs(campaign)
        })
    },
    computed: {
        //
    },
    components: {
        campaignlist,
        mycampaignlist
    },
    methods: {
        show(name) {
            this.$modal.show(name);
        },
        hide(name) {
            this.$modal.hide(name);
        },
        templateChunks(templates) {
            return _.chunk(templates, 2)
        },
        myTemplateChunks(mytemplates){
            return _.chunk(mytemplates, 2)
        },
        showJobs(campaign){
            let self = this
            self.current_campaign = campaign
            self.show('show-jobs-modal')
        },
        showMyJobs(campaign){
            let self = this
            self.mycurrent_campaign = campaign
            self.show('show-myjobs-modal')
        },
        closeJobsModal(){
            let self = this
            self.hide('show-jobs-modal')
            self.current_campaign = null
        },
        closeMyJobsModal(){
            let self = this
            self.hide('show-myjobs-modal')
            self.mycurrent_campaign = null
        },
        whenReady() {
        this.templates = this.templatelist
        this.mytemplates = this.mytemplatelist
        
        },
        cloneTemplate(id){
            let self = this
            Bus.$emit('clone-template',id)
        },
        cloneMyTemplate(id){
            let self = this
            Bus.$emit('myclone-template',id)
        },
        deleteTemplate(index,template){
            // Only the Project Creator Can Delete the template
            // guard (employee,projectable_type and id)
            // web ,tenant_id and auth user id
            let self = this
            self.toggleClonable(index,template)
            
        },
        deleteMyTemplate(index,mytemplate){
            // Only the Project Creator Can Delete the template
            // guard (employee,projectable_type and id)
            // web ,tenant_id and auth user id
            let self = this
            self.toggleClonable(index,mytemplate)
            
        },
        toggleClonable(index,template){
            let self = this
            self.guardAllowed(['web'],self.callToggleCloneApi(index,template))
        },
        toggleMyClonable(index,mytemplate){
            let self = this
            self.guardAllowed(['web'],self.callToggleMyCloneApi(index,mytemplate))
        },
        callToggleCloneApi(index,template)
        {
            let self = this
            self.current_index = index
            self.endpoints.web = `/projects/${template.id}/toggleClonable`
            axios.post(self.guardedLocation())
            .then((response) => {
                let index = _.findIndex(self.templates, { id: template.id })
                self.$delete(self.templates, index)
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
        callToggleMyCloneApi(index,mytemplate)
        {
            let self = this
            self.mycurrent_index = index
            self.endpoints.web = `/projects/${mytemplate.id}/toggleClonable`
            axios.post(self.guardedLocation())
            .then((response) => {
                let index = _.findIndex(self.mytemplates, { id: template.id })
                self.$delete(self.mytemplates, index)
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.mycurrent_index = null
            })
            .catch((error) => {
                if(response.data.message){
                    self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Server Failed To Serve the Request.', backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', }) 
                }
            })
        },
        goToDashboard(){
            window.location.href = `/dashboard`
        }
        
    },
    watch: {
        templates: {
            handler(newValue){
            },
            deep: true
          },
        mytemplates: {
        handler(newValue){
        },
        deep: true
        }
    },

})

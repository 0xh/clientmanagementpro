import guards from './../../mixins/guard'

Vue.component('manage-tenants', {
    mixins: [guards],
    props:['users'],
    data () {
        return {
            tenants: [],
            registerForm: new EvolutlyForm(Evolutly.forms.registerForm),
            current_user: null,
            current_index: null,
        }
    },
    mounted() {
        this.tenants = this.users
    },
    methods:{
        downgradeSubscription(tenant,tenantKey){
            let self = this
            self.current_user = tenant
            self.current_index = tenantKey
            self.callDowngradeApi()
        },
        upgradeSubscription(tenant,tenantKey){
            let self = this
            self.current_user = tenant
            self.current_index = tenantKey
            self.callUpgradeApi()
        },
        onTrial(tenant){
            return tenant.trial_ends_at != undefined && tenant.trial_ends_at > moment(new Date).format('YYYY-MM-DD')
        },
        isExpired(tenant){
            return tenant.subscriptions.ends_at < moment(new Date).format('YYYY-MM-DD') && tenant.subscriptions.length >0
        },
        isFreeLimeTimeUser(tenant){
            return tenant.lifetime === true
        },
        show(name) {
             this.$modal.show(name)
        },
        hide(name) {
             this.$modal.hide(name)
        },
        addTenantModal(){
            let self = this 
            self.resetRegisterForm()
            self.show('add-tenant-modal')
        },
        addTenant(){
            let self = this
            self.guardAllowed(['web'],self.callAddUserApi())
        },
        closeAddTenantModal(){
            let self = this
            self.resetRegisterForm()
            self.hide('add-tenant-modal')
        },
        resetCurrentUser(){
            let self = this
            self.current_user = null
            self.current_index = null
        },
        resetRegisterForm(){
            let self = this
            self.registerForm = new EvolutlyForm(Evolutly.forms.registerForm)
        },
        fillRegisterForm(tenant){
            let self = this
            self.registerForm.name = tenant.name
            self.registerForm.email = tenant.email
            self.registerForm.password = tenant.password
        },
        callAddUserApi(){
            let self = this
            self.registerForm.busy = true
            self.endpoints.web = '/users/add'
            axios.post(self.guardedLocation(), self.registerForm)
             .then((response) => {
                 self.registerForm.resetStatus()
                 self.resetRegisterForm()
                 self.tenants.push(response.data.user)
                 self.registerForm.busy = false
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                 self.closeAddTenantModal()
             })
             .catch((error) => {
                 self.registerForm.errors.set(error.response.data.errors)
                 self.registerForm.busy = false
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
            
        },
        showDeleteModal(tenant,tenantKey){
            let self = this
            self.current_user = tenant
            self.current_index = tenantKey
            self.guardAllowed(['web'],self.show('delete-tenant-modal'))
            
        },
        closeDeleteModal(){
            let self = this
            self.resetCurrentUser()
            self.guardAllowed(['web'],self.hide('delete-tenant-modal'))
            
        },
        deleteTenant(){
            let self = this
            self.endpoints.web = `/users/delete/${self.current_user.id}`
            axios.delete(self.guardedLocation())
            .then(function (response) {
                self.tenants.splice(self.current_index,1)
                self.resetCurrentUser()
                self.$popup({ message: `Tenant Has Been Deleted.`, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.hide('delete-tenant-modal')
            })
            .catch(error => {
                if(error.response.data.message){
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        callDowngradeApi(){
            let self = this
            self.endpoints.web = `/users/downgrade/${self.current_user.id}`
            axios.put(self.guardedLocation())
            .then(function (response) {
                self.$set(self.tenants, self.current_index, response.data.user)
                self.resetCurrentUser()
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
                self.hide('delete-tenant-modal')
            })
            .catch(error => {
                if(error.response.data.message){
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        callUpgradeApi(){
            let self = this
            self.endpoints.web = `/users/upgrade/${self.current_user.id}`
            axios.put(self.guardedLocation())
            .then(function (response) {
                self.$set(self.tenants, self.current_index, response.data.user)
                self.resetCurrentUser()
                self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
            })
            .catch(error => {
                if(error.response.data.message){
                    self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }else {
                    self.$popup({ message: 'Failed To Update Data in the Server', backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
                }
            })
        },
        impersonateTenant(id){
            let url = `/spark/kiosk/users/impersonate/${id}`
            window.location.href = url
        }
     }
});

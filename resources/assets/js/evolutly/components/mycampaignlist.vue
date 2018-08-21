<template>
<div style="padding:10px;">
  <li v-for="(campaign, cKey, cIndex) in campaigns" :key="cKey" :index="cIndex">
    <label class="input-control checkbox">
        <input type="checkbox"  :value="campaign.id" v-model="cloneCampaignForm.campaigns">
        <span class="check"></span>
        <span class="caption">{{ campaign.name }}</span>
    </label>
    <div @click="viewCampaignModal(campaign)" class="place-right" style="cursor:pointer;">
        <span data-role="hint" data-hint-mode="2" data-hint="View|Jobs List" data-hint-position="left" class="icon fg-green fa fa-tasks vertical-align-middle" style="position: relative;padding-top:8px;font-size:2.5em;"></span>
    </div>
</li>
</div>
</template>

<script>
import guards from './../../mixins/guard'
export default {
 mixins: [guards],
    props:['campaignlist','template'],
    data () {
        return {
            cloneCampaignForm: new EvolutlyForm(Evolutly.forms.cloneCampaignForm),
            campaigns: [],
        }
    },
    mounted() {
        let self = this
        self.campaigns = self.campaignlist
        self.cloneCampaignForm.campaigns = _.map(self.campaignlist,'id')
        Bus.$on('myclone-template', id => {
            if(self.template === id){
                self.callCloneApi(id)
            }
        })
    },
    methods:{
        viewCampaignModal(campaign){
            let self = this
            Bus.$emit('show-myjobs-modal',campaign)
        },
        callCloneApi(projectID){
            let self = this
            self.endpoints.web = `/clone/${projectID}`
            axios.post(self.guardedLocation(), self.cloneCampaignForm)
             .then((response) => {
                 self.cloneCampaignForm.resetStatus()
                 self.$popup({ message: response.data.message, backgroundColor: '#4db6ac', delay: 5, color: '#ffffff', })
             })
             .catch((error) => {
                 self.cloneCampaignForm.errors.set(error.response.data.errors)
                 self.$popup({ message: error.response.data.message, backgroundColor: '#e57373', delay: 5, color: '#ffffff', })
             })
            
        },
     }
}
</script>

<style>

</style>

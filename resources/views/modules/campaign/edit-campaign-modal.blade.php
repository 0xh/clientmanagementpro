<modal :name="'campaign-'+ campaign.id">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title">Edit @{{campaignForm.campaign_name}} <span @click="hide('campaign-'+ campaign.id)" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <form @submit.prevent="updateCampaign(campaign)" role="form" class="padding10">
                <div class="row">

                    <div class="input-control text full-size">
                        <input type="text" placeholder="Edit" v-model="campaignForm.campaign_name">
                        <input v-show="false" type="number" placeholder="Campaign Order" v-model="campaignForm.campaign_order">
                        <button type="submit" class="button fg-white" :class="{'info': !campaignForm.busy,'bg-red': campaignForm.busy}" :disabled="campaignForm.busy">
                            <span class="icon mif-keyboard-return" v-if="!campaignForm.busy"></span>
                            <span class="icon mif-spinner mif-ani-spin" v-else></span>
                    </button>
                    </div>
                </div>
                <div class="row align-center">
                    <span class="fg-red" v-show="campaignForm.errors.has('campaign_name')">
                            @{{ campaignForm.errors.get('campaign_name') }}
                    </span>
                </div>
            </form>
        </div>
    </div>
</modal>
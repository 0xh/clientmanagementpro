<modal :name="project.slug" :adaptive="true" :resizable="true"> 
    <div class="panel widget-box success">
        <div class="heading">
            <div class="title align-center">Progress <span @click="hide(project.slug)" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content" v-show="campaigns.length > 0">
            <div v-for="campaign in campaigns"> 
            <progress-bar :name="campaign.name" :progress="campaignProgress(campaign)"></progress-bar>
            </div>
        </div>
        <div class="content" v-show="campaigns.length == 0" >
            <div class="align-center" style="padding-top: 50px;">
            <h1 class="fg-amber">No Progress Yet.</h1>
            </div>
        </div>
    </div>
</modal>
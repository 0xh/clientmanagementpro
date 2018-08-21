@push('critical_css')
<style>
.tabcontrol .frames .frame .removeborder {
    padding: 0 !important;
}
</style>
@endpush

<div class="frame bg-white margin-bottom-90" id="my_template" v-if="mytemplates.length >0" style="min-height:450px;">
        <div class="panel widget-box collapsible" data-role="panel">
            <div class="row cells2" v-for="(myChunk, myKeyChunk, myIndexChunk) in myTemplateChunks(mytemplates)"
                :key="myKeyChunk" :index="myIndexChunk">
    
                <div class="cell colspan1" v-for="(mytemplate, mycKey, mycIndex) in myChunk" style="min-height: 150px;" :index="mycIndex" :key="mycKey" 
                >
                    <div class="panel">
                        <div class="heading bg-lightBlue">
                            <div style="position:absolute;top:12px;margin-left:136px;">
                                <span>
                                    @{{ mytemplate.name }}
                                </span>
                            </div>
                            <!-- Add Check All Button that will Select All Campaigns -->
                            <div v-if="guard === 'web'" @click="cloneMyTemplate(mytemplate.id)" class="align-center bg-cyan place-left" style="cursor:pointer;position:absolute;top:0;left:0;width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Clone|Template" data-hint-position="top">
                                <span class="icon  mif-stack3" style="position: relative;top: 50% !important; transform: translateY(-50%) !important;"></span>
                            </div>  
                            <!-- Only show the delete button to SuperAdmin -->
                            <div v-if="guard === 'web'" @click="deleteMyTemplate(mycKey,mytemplate)" class="align-center bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Delete|Template" data-hint-position="top">
                                <span class="icon fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                            </div>
                        </div>
                        <div class="content">
                                <ul class="todo-list" v-if="mytemplate.campaigns">
                                    <!-- all list of campaign checked -->
                                    <mycampaignlist :campaignlist="mytemplate.campaigns" :template="mytemplate.id">
                                    </mycampaignlist>
                                </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="frame bg-white margin-bottom-90" id="my_template" v-else style="min-height:450px;">
            <h2 class="fg-teal align-center"><span class="tag bg-red fg-white">You Have No Available Templates.</span></h2>
            <h2 class="fg-teal align-center" style="padding-bottom:250px;"><span class="tag success" @click="goToDashboard()" style="cursor:pointer;">Clone an Existing Project Or Create then Clone A Project</span></h2>    
        </div>
            
    
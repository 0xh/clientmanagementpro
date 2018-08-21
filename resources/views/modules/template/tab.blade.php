@push('critical_css')
<style>
.tabcontrol .frames .frame .removeborder {
    padding: 0 !important;
}
</style>
@endpush
<div class="frame bg-white margin-bottom-90" id="template_tab" v-if="templates.length > 0" style="min-height:450px;">
    <div class="panel widget-box collapsible" data-role="panel">
        <div class="row cells2" v-for="(chunk, keyChunk, indexChunk) in templateChunks(templates)"
            :key="keyChunk" :index="indexChunk">

            <div class="cell colspan1" v-for="(template, cKey, cIndex) in chunk" style="min-height: 150px;" :index="cIndex" :key="cKey" 
            >
                <div class="panel">
                    <div class="heading bg-lightBlue">
                        <div style="position:absolute;top:12px;margin-left:136px;">
                            <span>
                                @{{ template.name }}
                            </span>
                        </div>
                        <!-- Add Check All Button that will Select All Campaigns -->
                        <div v-if="guard === 'web'" @click="cloneTemplate(template.id)" class="align-center bg-cyan place-left" style="cursor:pointer;position:absolute;top:0;left:0;width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Clone|Template" data-hint-position="top">
                            <span class="icon  mif-stack3" style="position: relative;top: 50% !important; transform: translateY(-50%) !important;"></span>
                        </div>  
                        <!-- Only show the delete button to SuperAdmin -->
                        <div v-if="guard === 'web'" @click="deleteTemplate(cKey,template)" class="align-center bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Delete|Template" data-hint-position="top">
                            <span class="icon fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                        </div>
                    </div>
                    <div class="content">
                            <ul class="todo-list" v-if="template.campaigns">
                                <!-- all list of campaign checked -->
                                <campaignlist :campaignlist="template.campaigns" :template="template.id">
                                </campaignlist>
                            </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="frame bg-white margin-bottom-90" id="template_tab" v-else style="min-height:450px;">
    <h2 class="fg-teal align-center"><span class="tag bg-red fg-white">No Available Templates.</span></h2>
    <h2 class="fg-teal align-center" style="padding-bottom:250px;"><span class="tag success" @click="goToDashboard()" style="cursor:pointer;">Create Project First Then Clone It.</span></h2>    
</div>
    
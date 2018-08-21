<div class="frame bg-white margin-bottom-90" id="tasks_tab" v-if="campaigns.length > 0" style="min-height:450px;">
    <div class="panel widget-box collapsible" data-role="panel">
        <div class="row cells2" v-for="(chunk, keyChunk) in campaignChunks(campaigns)"
            :key="keyChunk">

            <draggable class="cell colspan1" v-for="(campaign, cKey) in chunk" :options="draggableOptions"
                :data-id="campaign.id" :key="cKey" @start="onStart" @end="onEnd" style="min-height: 150px;" :cKey="cKey" :keyChunk="keyChunk"
            >
                <div class="panel">
                    <div class="heading draghandle bg-lightBlue" :style="{cursor: moveable}">
                        <div v-if="guard === 'web'" style="position:absolute;top:12px;margin-left:136px;">
                            <span data-role="hint" data-hint-mode="2" data-hint="Switch|Re-Order Campaign" data-hint-position="top">
                                @{{ campaign.name }}
                            </span>
                        </div>
                        <div v-else class="align-center">
                                <span>
                                    @{{ campaign.name }}
                                </span>
                        </div>
                        <div v-if="guard === 'web'" @click="editCampaignModal(campaign)" class="align-center bg-cyan place-left" style="cursor:pointer;position:absolute;top:0;left:0;width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Edit|Campaign" data-hint-position="top">
                            <span class="icon  fa fa-pencil-square-o" style="position: relative;top: 50% !important; transform: translateY(-50%) !important;"></span>
                        </div>
                        <div v-if="guard === 'web'" @click="showTask(campaign.id)" class="align-center bg-amber place-left" style="cursor:pointer;position:absolute;top:0;margin-left:53px; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Add|Job" data-hint-position="top">
                            <span class="icon mif-plus" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                        </div>
                        <div v-if="guard === 'web'" @click="showDeleteCampaignModal(campaign.id)" class="align-center bg-red place-right" style="cursor:pointer;position:absolute;top:0;right:0; width: 53px; height: 53px;" data-role="hint" data-hint-mode="2" data-hint="Delete|Campaign" data-hint-position="top">
                            <span class="icon fa fa-trash" style="position: relative; top: 50%; transform: translateY(-50%);"></span>
                        </div>
                    </div>
                    <div class="content">
                        <div class="text">
                            <ul class="todo-list" v-if="campaign.tasks.length >0">
                                <li v-for="(task, tKey, tIndex) in campaign.tasks" :key="tKey" :index="tIndex" style="padding:10px;">
                                    <label class="input-control checkbox" onclick="return false;" style="cursor:default;">
                                        <input type="checkbox" class="todo-cb" v-model="task.done">
                                        <span class="check"></span>
                                        <span class="caption"
                                        @click="viewTask(task.id)" style="cursor:pointer;" :class="{ 'todo-completed': isTaskDone(task) }">@{{ task.name }}</span>
                                    </label>
                                    <div @click="viewTask(task.id)" class="place-right" style="cursor:pointer;">
                                        <span data-role="hint" data-hint-mode="2" data-hint="View|Job" data-hint-position="left" class="icon fg-green fa fa-tasks vertical-align-middle" style="position: relative;padding-top:8px;font-size:2.5em;"></span>
                                        <span data-role="hint" data-hint-mode="2" data-hint="Progress|Done Points / Total Points" data-hint-position="left" class="math-box place-left" style="padding:11px;"><span class="strut" style="height: 2.008em; vertical-align: -0.686em;"></span><span class="vstack"><div style="top: 0.686em;color:#80cbc4;">@{{ task.total_points}}</div><div style="top: -0.23em;"><span class="frac-line"></span></div><div style="top: -0.677em;color: #e57373;">@{{ task.done_points }}</div><span class="baseline-fix"></span></span></span>
                                    </div>
                                </li>
                            </ul>
                            <div class="todo-list" v-else style="min-height:200px;padding-top:35px;" class="v-align-middle">
                                <div v-if="guard === 'web'" class="fg-cyan align-center">
                                <h4 class="fg-cyan"><strong>No Jobs Yet For This Campaign</strong></h4>
                                    <button @click="showTask(campaign.id)" class="button info"><span class="mif-plus"></span> Create Your First Job...</button>
                                </div>
                            </div>
                        </div>
                    </div>
            </draggable>
            @include('campaign::edit-campaign-modal')
            @include('campaign::delete-campaign-modal')
            </div>
        </div>
    </div>
</div>
<div class="frame bg-white" id="tasks_tab" v-else>
        <div class="row" style="min-height:450px;">
            <div class="cell align-center">
                <h4 class="fg-cyan"><strong>You Have No Campaign Yet</strong></h4>
                <a href="#!" v-if="guard === 'web'" class="fg-cyan">
                    <button @click="showCampaignModal()" class="button info"><span class="mif-plus"></span> Create Your First Campaign...</button>
                </a>
            </div>
        </div>
        
</div>
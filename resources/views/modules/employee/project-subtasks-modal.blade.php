<modal v-if="current_task != undefined" :name="`task-subtasks-modal-${current_task.id}`" :pivot-x=".5" :pivot-y=".1" :adaptive="true"  height="auto" :scrollable="true">
    <div class="panel widget-box" style="min-height: 500px;">
        
                <div class="heading" style="background-color:#4db6ac;">
                    <div class="title align-center" ><span @click="viewJob(task.id)">@{{ current_task.name }}</span><span @click="closeAssignedSubtaskModal(current_task)" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
                </div>
                
                <div class="content">
        
                    <div class="text">

                        <table class="table border bordered">
                                <thead class="">
                                    <tr>
                                        <th>Task</th>
                                        <th>Status</th>
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor:default;">
                                    <tr v-for="(subtask,subtaskKey) in membertasks">
                                        <td><span  style="cursor:pointer;">@{{ subtask.name }}</span></td>

                                        <td class="align-center">
                                            <span class="tag bg-green fg-white" v-if="subtask.done">Done
                                            </span>
                                            <span class="tag bg-red fg-white" v-else-if="overDueDate(subtask)">Overdue
                                            </span>
                                            <span class="tag bg-amber fg-white" v-else>Ongoing
                                            </span>
                                        </td>
                                        <td>@{{ subtask.due_date | date }}</td>

                                        <td class="align-center" style="font-size: 1.25rem">
                                            <span @click="removeSubtask(current_task,current_employee,subtask)" class="icon mif-event-busy fg-red" style="cursor:pointer;" ></span> 
                                        </td>
                                    </tr>
                                </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="row" style="position: absolute;width: 100%;bottom:0;">
                <button @click="deleteJob()" type="button" class="button fg-white" style="width:100%; margin-bottom:-1px;background-color:#b71c1c;">
                    <strong>Remove All Task From This Client</strong>
                </button>
            </div>
</modal>
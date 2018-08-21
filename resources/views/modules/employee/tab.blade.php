<div class="frame bg-white" id="people_tab" v-if="teammember.length > 0">
    <div class="row cells4" v-for="(chunk, index) in employeeChunks" :key="chunk.id" :index="index" :chunk="chunk">
        <div class="cell" v-for="(employee, index) in chunk" :key="employee.id" :index="index" :employee="employee">
            <a  @click="viewEmployeeSubtasks(employee)" style="cursor:pointer;">
                <img :src="employee.photo_url" 
                    :alt="employee.name"
                    style="border: 2px solid #d3e0e9;
                        border-radius: 50%;
                        height: 40px;
                        padding: 2px;
                        width: 40px;
                        height: 50px;
                        width: 50px;"
                >
                @{{ employee.name }}
            </a>
            <modal :name="`view-all-subtasks-modal-${employee.id}`" :pivot-x=".5" :pivot-y=".1" :adaptive="true"  height="auto" :scrollable="true">
                <div class="panel widget-box" style="min-height: 500px;">
                    
                            <div class="heading" style="background-color:#4db6ac;">
                                <div class="title align-center" ><span>@{{ employee.name }}</span><span @click="closeEmployeeTasks(employee)" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
                            </div>
                            
                            <div class="content">
                    
                                <div class="text">
            
                                    <table class="table border bordered" v-if="membertasks.length > 0">
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
                                                    <td>@{{ subtask.name }}</td>
            
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
                                                        <span @click="unassigneSubtask(employee,subtask)" class="icon mif-event-busy fg-red" style="cursor:pointer;" ></span> 
                                                    </td>
                                                </tr>
                                            </tbody>
                                    </table>
            
                                </div>
                            </div>
                        </div>
                        <div class="row" style="position: absolute;width: 100%;bottom:0;">
                            <button @click="deleteAllSubtasks(employee)" type="button" class="button fg-white" style="width:100%; margin-bottom:-1px;background-color:#b71c1c;">
                                <strong>Remove All Task From This Client</strong>
                            </button>
                        </div>
            </modal>
        </div>
    </div>
</div>
<div class="frame bg-white" id="people_tab" v-else>
    <div class="row" style="min-height:450px;">
        <div class="cell align-center">
            <h4 class="fg-lightRed">No Team Member Yet is Assigned To Any Of The Task For this Job!</h4>
            <h4 class="tag bg-blue fg-white" style="cursor:pointer; font-size:20px;"><strong @click="addSubtaskModal()">Create a New Task and Assign A Team Member To That Task</strong></h4>
        </div>
    </div>
    
</div>
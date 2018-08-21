<div class="row cells">
    <div class="cell">
        <div class="panel widget-box " data-role="panel">
            <div class="heading">
                <div class="title">Tasks</div>
            </div>
            <div class="content">
                <div class="sub-heading bg-chess" v-if="guard === 'web'">
                    <a  @click="addSubtaskModal()">
                    <button class="button info"><span class="mif-plus"></span> Add Task</button>
                    </a>
                </div>
                <div class="text">

                    <div class="table-responsive" v-if="subtasks.length > 0">

                        <table class="table border bordered striped ">
                            <thead class="">
                                <tr>
                                    <th>Task</th>
                                    <th v-if="guard != 'client'">Priority</th>
                                    <!-- <th v-if="guard != 'client'">Video</th> -->
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th v-if="guard != 'client'">Assigned To</th>
                                    <th v-if="guard != 'client'">Action</th>
                                </tr>
                            </thead>
                            <tbody v-for="(subtask, subtaskKey) in subtasks">
                                <tr v-if="assignedTask(subtask)">
                                    <td>@{{ subtask.name }}</td>
                                    <td v-if="guard != 'client'" class="align-center" @mouseover="setCurrentSubtask(subtask)">
                                        <star-rating @rating-selected="setRating" :read-only="guard !== 'web'" v-model="subtask.priority" :star-size="30" :show-rating="false"></star-rating>
                                    </td>
                                    <!--
                                    <td v-if="guard != 'client'" class="align-center">
                                        <span class="tag" :class="{ info: subtask.link}">
                                            <span v-if="subtask.link" class="icon mif-eye" @click="viewVideoLink(subtask)" style="cursor: pointer;">
                                            </span>
                                            <span v-else class="icon mif-minus fg-red">

                                            </span>
                                        </span>
                                    </td>
                                    -->
                                    <td class="align-center">
                                        <span class="tag bg-green fg-white" v-if="subtask.done">Done
                                        </span>
                                        <span class="tag bg-red fg-white" v-else-if="overDueDate(subtask)">Overdue
                                        </span>
                                        <span class="tag bg-amber fg-white" v-else>Ongoing
                                        </span>
                                    </td>
                                    <td>
                                    @{{ subtask.due_date | date }}
                                    </td>
                                    <td v-if="guard != 'client'">
                                        <span class="tag bg-blue fg-white" v-for="(employee,employeeKey) in subtask.employees">@{{ employee.name }}
                                        </span>
                                    </td>
                                    <td  class="align-center" style="font-size: 1.25rem">
                                        <span  class="fg-yellow icon fa fa-eye" @click="viewSubtask(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" data-hint="View|Task" data-hint-position="top"
                                        >
                                        </span>
                                        <span v-if="guard === 'web'" class="fg-lightBlue icon mif-pencil" @click="editSubtaskModal(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" data-hint="Edit|Task" data-hint-position="top"
                                        >
                                        </span>
                                        @include('subtask::edit-subtask-modal')
                                        <span v-if="guard === 'web'" class="fg-red icon fa fa-trash" @click="deleteSubtask(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" data-hint="Delete|Task" data-hint-position="top"
                                        >
                                        </span>
                                        <span v-if="guard != 'client'" class="tag" :class="{success: !subtask.done}" @click="toggleDone(subtask)" style="cursor:pointer;"
                                        data-role="hint" data-hint-mode="2" data-hint="Toggle|Done/Undone Task" data-hint-position="top">
                                            <span class="icon mif-checkmark" v-if="!subtask.done">
                                            </span>
                                            <span class="fg-amber icon mif-blocked" v-else>
                                            </span>
                                        </span>
                                    </td>
                                </tr>
                                <!-- Add Here Dynamic Modal For Edit Subtask -->
                            </tbody>
                            
                        </table>

                    </div>
                    <div v-else class="align-center v-align-middle">
                            <h2 class="fg-teal"><span class="tag info">NO TASKS AVAILABLE...</span></h2>
                    </div>


                </div>
            </div>
        </div>




    </div>
</div>

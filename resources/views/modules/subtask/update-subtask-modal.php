<modal name="update-subtask-modal" :click-to-close="false" :pivot-x=".5" :pivot-y=".1" :adaptive="true" width="500px" height="auto" :scrollable="true">
        <form @submit.prevent="editSubtask()" role="form" class="">
        <div class="panel widget-box">
            
                    <div class="heading" style="background-color:#4db6ac;">
                        <div class="title window-header align-center">Edit Task <span @click="closeEditSubtask()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
                    </div>
            
                    <div class="content">
            
                            <div class="text">
            
                                <div class="row">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-file-text fg-lime"></span>
                                        <input type="text" placeholder="Add Name" v-model="subtaskForm.name">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('name')">
                                        {{ subtaskForm.errors.get('name') }}
                                    </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-control text full-size">
                                        <span class="prepend-icon mif-calendar fg-amber"></span>
                                        <input type="date" placeholder="YYYY-MM-DD" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}"  v-model="subtaskForm.due_date">
                                        <span class="fg-red" v-show="subtaskForm.errors.has('due_date')">
                                    {{ subtaskForm.errors.get('due_date') }}
                                    </span>
                                    </div>
                                </div>
                                <div  class="row" style="padding:5px;margin-top:25px;">
                                    <div class="input-control text full-size">
                                        <label class="switch">
                                            <input type="checkbox" v-model="subtaskForm.done">
                                            <span class="check"></span>
                                            <span class="caption" v-if="subtaskForm.done">Undone</span>
                                            <span class="caption" v-else>Mark As Done</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row" style="position: absolute;width: 100%;bottom:0;">
                    <button type="submit" class="button fg-white" :class="{'bg-teal': !subtaskForm.busy,'bg-red': subtaskForm.busy}" style="width:500px; margin-bottom:-1px;" :disabled="subtaskForm.busy">
                        <strong v-if="!subtaskForm.busy">Update Task</strong>
                        <strong class="icon mif-spinner mif-ani-spin" v-else></strong>
                    </button>
                </div>
        </form>
    </modal>
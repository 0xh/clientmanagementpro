<modal name="edit-task-modal" :width="500" :height="550" draggable=".window-header">
        <form @submit.prevent="updateTask()" role="form" class="">
        <div class="panel widget-box">
    
            <div class="heading" style="background-color:#4db6ac;">
                <div class="title window-header align-center">Edit Job <span @click="hide('edit-task-modal')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
    
            <div class="content">
    
                    <div class="text">
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-file-text fg-lime"></span>
                                <input type="text" placeholder="Add Name" v-model="taskForm.task_name">
                                <span class="fg-red" v-show="taskForm.errors.has('task_name')">
                                @{{ taskForm.errors.get('task_name') }}
                            </span>
                            </div>
                        </div>
                        <!-- remove for the mean time 
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-link fg-darkCyan"></span>
                                <input type="text" placeholder="Add Link" v-model="taskForm.task_link">
                                <span class="fg-red" v-show="taskForm.errors.has('task_link')">
                            @{{ taskForm.errors.get('task_link') }}
                            </span>
                            </div>
                        </div>
                        -->
                        <div  class="row" style="padding:5px;margin-top:15px;">
                                <div class="input-control text full-size">
                                    <label class="switch">
                                        <input type="checkbox" v-model="taskForm.task_recurring">
                                        <span class="check"></span>
                                        <span class="caption">Repeat?</span>
                                    </label>
                                </div>
                            </div>
                            <div v-if="taskForm.task_recurring" class="row" style="padding:5px; margin-top:-50px;">
                                <div class="cell">
                                    <label class="input-control checkbox">
                                            <input type="radio" :value="1" v-model.number="taskForm.task_interval">
                                            <span class="check"></span>
                                            <span class="caption">Daily</span>
                                    </label>
                                    <label class="input-control checkbox">
                                            <input type="radio" :value="7"  v-model.number="taskForm.task_interval">
                                            <span class="check"></span>
                                            <span class="caption">Weekly</span>
                                    </label>
                                    <label class="input-control checkbox">
                                            <input type="radio" :value="30"  v-model.number="taskForm.task_interval">
                                            <span class="check"></span>
                                            <span class="caption">Monthly</span>
                                    </label>
                                    <label class="input-control checkbox">
                                            <input type="radio" :value="365"  v-model.number="taskForm.task_interval">
                                            <span class="check"></span>
                                            <span class="caption">Yearly</span>
                                    </label>
                                </div>                                    
                            </div>
                            <div class="row" style="padding:5px;" v-if="taskForm.task_recurring">
                                    <div class="input-control text full-size" >
                                            <span class="prepend-icon mif-sun fg-yellow"></span>
                                            <input type="number" placeholder="No. Of Days" v-model="taskForm.task_interval">
                                            <span class="fg-red" v-show="taskForm.errors.has('task_interval')">
                                                @{{ taskForm.errors.get('task_interval') }}
                                            </span>
                                    </div>
                            </div>
                        <!-- remove for the mean time -->
                        <!-- <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <textarea placeholder="Add Description" v-model="taskForm.task_description"></textarea>
                                <span class="fg-red" v-show="taskForm.errors.has('task_description')">
                            @{{ taskForm.errors.get('task_description') }}
                            </span>
                            </div>
                        </div> -->
    
                    </div>
            </div>
    
        </div>
        <div class="row" style="position: absolute;width: 100%;bottom:0;">
            <button type="submit" class="button fg-white" :class="{'bg-teal': !taskForm.busy,'bg-red': taskForm.busy}" style="width:500px; margin-bottom:-1px;" :disabled="taskForm.busy">
                <strong v-if="!taskForm.busy">Update Job</strong>
                <strong class="icon mif-spinner mif-ani-spin" v-else></strong>
            </button>
        </div>
        </form>
    </modal>
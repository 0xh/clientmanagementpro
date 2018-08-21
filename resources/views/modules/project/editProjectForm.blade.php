@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }
</style>
@endpush
<modal name="edit-project" :width="500" :height="500" draggable=".window-header">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title window-header">Edit Client Name<span @click="closeEditProjectModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                    @if($guard === 'web')
                    <div class="input-control text full-size">
                    <form @submit.prevent="updateProjectName()" role="form" class="padding10">
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-folder-special fg-yellow"></span>
                                <input type="text" placeholder="Describe Your Client?" v-model="editProjectForm.client_name">
                                <span class="fg-red" v-show="editProjectForm.errors.has('client_name')">
                                @{{ editProjectForm.errors.get('client_name') }}
                            </span>
                            </div>
                        </div>
                        <div  class="row" style="padding:5px;margin-top:15px;">
                            <div class="input-control text full-size">
                                <label class="switch">
                                    <input type="checkbox" v-model="editProjectForm.newclient">
                                    <span class="check"></span>
                                    <span class="caption" v-if="!editProjectForm.newclient">New Client?</span>
                                    <span class="caption" v-else>Create New Client</span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="editProjectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-user fg-blue"></span>
                                <input type="text" placeholder="Company Name" v-model="editProjectForm.client.name">
                                <span class="fg-red" v-show="editProjectForm.errors.has('client.name')">
                                @{{ editProjectForm.errors.get('client.name') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="editProjectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-link fg-blue"></span>
                                <input type="text" placeholder="Website" v-model="editProjectForm.website">
                                <span class="fg-red" v-show="editProjectForm.errors.has('website')">
                                @{{ editProjectForm.errors.get('website') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="editProjectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-mail fg-blue"></span>
                                <input type="text" placeholder="Email" v-model="editProjectForm.client.email">
                                <span class="fg-red" v-show="editProjectForm.errors.has('client.email')">
                                @{{ editProjectForm.errors.get('client.email') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="editProjectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-spell-check fg-blue"></span>
                                <input type="text" placeholder="Password" v-model="editProjectForm.client.password">
                                <span class="fg-red" v-show="editProjectForm.errors.has('client.password')">
                                @{{ editProjectForm.errors.get('client.password') }}
                            </span>
                            </div>
                        </div>
                        <v-select max-height="200px" v-if="clients.length > 0 && editProjectForm.newclient == false" v-model="editProjectForm.client_id" label="name" :options="clients"  placeholder="Pick an Existing Client"></v-select>
                        <!-- we need to easily create a client without an email or had a default email -->
                        <button type="submit" class="button fg-white" :class="{'bg-teal': !editProjectForm.busy,'bg-red': editProjectForm.busy}" style="position:absolute;top:24px;right: 17px; height:43px;" :disabled="editProjectForm.busy">
                                <span class="icon mif-keyboard-return" v-if="!editProjectForm.busy"> Update</span>
                                <span class="icon mif-spinner mif-ani-spin" v-else></span>
                        </button>
                    </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</modal>
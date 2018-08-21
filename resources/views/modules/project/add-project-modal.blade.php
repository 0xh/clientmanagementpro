@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }
</style>
@endpush
<modal name="add-project" :width="500" :height="500" draggable=".window-header">
    <div class="panel widget-box">
        <div class="heading">
            <div class="title window-header">Create New Client <span @click="hide('add-project')" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
        </div>
        <div class="content">
            <div class="row">
                    @if($guard === 'web')
                    <div class="input-control text full-size">
                    <form @submit.prevent="createProject()" role="form" class="padding10">
                        {{ csrf_field() }}
                        <input type="text" placeholder="Name Your Client Project" v-model="projectForm.client_name">
                        </br>
                        </br>
                        <div  class="row" style="padding:5px;margin-top:15px;">
                            <div class="input-control text full-size">
                                <label class="switch">
                                    <input type="checkbox" v-model="projectForm.newclient">
                                    <span class="check"></span>
                                    <span class="caption" v-if="!projectForm.newclient">New Client?</span>
                                    <span class="caption" v-else>Create New Client</span>
                                </label>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="projectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-user fg-blue"></span>
                                <input type="text" placeholder="Company Name" v-model="projectForm.client.name">
                                <span class="fg-red" v-show="projectForm.errors.has('client.name')">
                                @{{ projectForm.errors.get('client.name') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="projectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-link fg-blue"></span>
                                <input type="text" placeholder="Website" v-model="projectForm.website">
                                <span class="fg-red" v-show="projectForm.errors.has('website')">
                                @{{ projectForm.errors.get('website') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="projectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-mail fg-blue"></span>
                                <input type="text" placeholder="Email" v-model="projectForm.client.email">
                                <span class="fg-red" v-show="projectForm.errors.has('client.email')">
                                @{{ projectForm.errors.get('client.email') }}
                            </span>
                            </div>
                        </div>
                        <div class="row" style="padding:5px;" v-if="projectForm.newclient">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-spell-check fg-blue"></span>
                                <input type="text" placeholder="Password" v-model="projectForm.client.password">
                                <span class="fg-red" v-show="projectForm.errors.has('client.password')">
                                @{{ projectForm.errors.get('client.password') }}
                            </span>
                            </div>
                        </div>
                        <v-select max-height="200px" v-if="clients.length > 0 && projectForm.newclient == false" v-model="projectForm.client_id" label="name" :options="clients"  placeholder="Pick an Existing Client"></v-select>
                        <!-- we need to easily create a client without an email or had a default email -->
                        <button type="submit" class="button place-right fg-white" :class="{'bg-teal': !projectForm.busy,'bg-red': projectForm.busy}" style="position:absolute;top:64px;right: 12px; height:36px;" :disabled="projectForm.busy">
                                <span class="icon mif-keyboard-return" v-if="!projectForm.busy"> Submit</span>
                                <span class="icon mif-spinner mif-ani-spin" v-else></span>
                        </button>
                    </form>
                    </div>
                    @endif
            </div>
        </div>
    </div>
</modal>
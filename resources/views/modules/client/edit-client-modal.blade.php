@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }

</style>
@endpush
<modal name="edit-client-modal" :pivot-x=".5" :pivot-y=".1" :adaptive="true" width="500px" height="auto" :scrollable="true">
    <form @submit.prevent="editClient()" role="form" class="">
    <div class="panel widget-box">

        <div class="heading" style="background-color:#4db6ac;">
            <div class="title align-center">Edit Client<span @click="closeEditModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
        </div>

        <div class="content">

                <div class="text">

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon fa fa-briefcase fg-teal"></span>
                            <input type="text" placeholder="Company" v-model="registerForm.name">
                            <span class="fg-red" v-show="registerForm.errors.has('name')">
                        @{{ registerForm.errors.get('name') }}
                        </span>
                        </div>
                    </div>
                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-user fg-olive"></span>
                            <input type="text" placeholder="First Name" v-model="registerForm.first_name">
                            <span class="fg-red" v-show="registerForm.errors.has('first_name')">
                        @{{ registerForm.errors.get('first_name') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-users fg-steel"></span>
                            <input type="text" placeholder="Last Name" v-model="registerForm.last_name">
                            <span class="fg-red" v-show="registerForm.errors.has('last_name')">
                        @{{ registerForm.errors.get('last_name') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon fa fa-phone fg-grayDarker"></span>
                            <input type="text" placeholder="Contact No." v-model="registerForm.phone">
                            <span class="fg-red" v-show="registerForm.errors.has('phone')">
                        @{{ registerForm.errors.get('phone') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-map fg-teal"></span>
                            <input type="text" placeholder="Address 1" v-model="registerForm.address">
                            <span class="fg-red" v-show="registerForm.errors.has('address')">
                        @{{ registerForm.errors.get('address') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-map2 fg-teal"></span>
                            <input type="text" placeholder="Address 2" v-model="registerForm.address_line_2">
                            <span class="fg-red" v-show="registerForm.errors.has('address_line_2')">
                        @{{ registerForm.errors.get('address_line_2') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-location-city fg-darkTeal"></span>
                            <input type="text" placeholder="City" v-model="registerForm.city">
                            <span class="fg-red" v-show="registerForm.errors.has('city')">
                        @{{ registerForm.errors.get('city') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-compass2 fg-amber"></span>
                            <input type="text" placeholder="Province/State" v-model="registerForm.zip">
                            <span class="fg-red" v-show="registerForm.errors.has('zip')">
                        @{{ registerForm.errors.get('zip') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-flag fg-lime"></span>
                            <input type="text" placeholder="Country" v-model="registerForm.country">
                            <span class="fg-red" v-show="registerForm.errors.has('country')">
                        @{{ registerForm.errors.get('country') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-facebook fg-cobalt"></span>
                            <input type="text" placeholder="Facebook" v-model="registerForm.links.facebook">
                            <span class="fg-red" v-show="registerForm.errors.has('links.facebook')">
                        @{{ registerForm.errors.get('links.facebook') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-twitter fg-cyan"></span>
                            <input type="text" placeholder="Twitter" v-model="registerForm.links.twitter">
                            <span class="fg-red" v-show="registerForm.errors.has('links.twitter')">
                        @{{ registerForm.errors.get('links.twitter') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-linkedin fg-darkCyan"></span>
                            <input type="text" placeholder="LinkedIn" v-model="registerForm.links.linkedin">
                            <span class="fg-red" v-show="registerForm.errors.has('links.linkedin')">
                        @{{ registerForm.errors.get('links.linkedin') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-google-plus fg-lightRed"></span>
                            <input type="text" placeholder="Google+" v-model="registerForm.links.googleplus">
                            <span class="fg-red" v-show="registerForm.errors.has('links.googleplus')">
                        @{{ registerForm.errors.get('links.googleplus') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-youtube fg-red"></span>
                            <input type="text" placeholder="Youtube" v-model="registerForm.links.youtube">
                            <span class="fg-red" v-show="registerForm.errors.has('links.youtube')">
                        @{{ registerForm.errors.get('links.youtube') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-instagram fg-taupe"></span>
                            <input type="text" placeholder="Instagram" v-model="registerForm.links.instagram">
                            <span class="fg-red" v-show="registerForm.errors.has('links.instagram')">
                        @{{ registerForm.errors.get('links.instagram') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-earth fg-darkBlue"></span>
                            <input type="text" placeholder="Website" v-model="registerForm.website">
                            <span class="fg-red" v-show="registerForm.errors.has('website')">
                        @{{ registerForm.errors.get('website') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span class="prepend-icon mif-mail fg-yellow"></span>
                            <input type="text" placeholder="Client Email" v-model="registerForm.email">
                            <span class="fg-red" v-show="registerForm.errors.has('email')">
                            @{{ registerForm.errors.get('email') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;">
                        <div class="input-control text full-size">
                            <span v-if="registerForm.hidden" class="prepend-icon mif-spell-check fg-darkCyan" @click="registerForm.hidden = false"></span>
                            <span v-else class="prepend-icon mif-eye fg-darkCyan" @click="registerForm.hidden = true"></span>
                            <input v-if="registerForm.hidden" type="password" placeholder="New Password" v-model="registerForm.password">
                            <input v-else type="text" placeholder="New Password" v-model="registerForm.password">
                            <span class="fg-red" v-show="registerForm.errors.has('password')">
                        @{{ registerForm.errors.get('password') }}
                        </span>
                        </div>
                    </div>

                    <div class="row" style="padding:5px;margin-bottom:15px;">
                            <div class="input-control text full-size">
                                <span v-if="registerForm.hidden" class="prepend-icon mif-spell-check fg-darkCyan" @click="registerForm.hidden = false"></span>
                                <span v-else class="prepend-icon mif-eye fg-darkCyan" @click="registerForm.hidden = true"></span>
                                <input v-if="registerForm.hidden" type="password" placeholder="Confirm Password" v-model="registerForm.password_confirmation">
                                <input v-else type="text" placeholder="Confirm New Password" v-model="registerForm.password_confirmation">
                                <span class="fg-red" v-show="registerForm.errors.has('password_confirmation')">
                            @{{ registerForm.errors.get('password') }}
                            </span>
                            </div>
                    </div>
                    <v-select style="margin-bottom:50px;" max-height="160px" class="full-size" v-if="options.length > 0" multiple  v-model="registerForm.assignedProjects" label="slug" :options="options"  placeholder="Pick Unassigned Projects For this Client"></v-select>
                    
                    <div  class="row" style="padding:5px;margin-bottom:-25px;">
                        <div class="input-control text full-size">
                            <label class="switch pull-left">
                                <input type="checkbox" v-model="registerForm.new_project">
                                <span class="check"></span>
                                <span class="caption" v-if="!registerForm.new_project">Create New Project?</span>
                                <span class="caption" v-else>Create Project</span>
                            </label>
                            <span v-if="registerForm.new_project" @click="newProjectInput()" class="pull-right" style="margin-top:-17px;cursor:pointer;padding-right:5px;"><span class="icon mif-folder-plus fg-green"></span></span>
                        </div>
                    </div>
                    <div v-if="registerForm.new_project" v-for="(project,projectKey, projectIndex) in registerForm.projects" :key="projectKey" :index="projectIndex" style="margin-bottom:20px;">
                        <div class="full-size">Project @{{ projectKey + 1 }}<span @click="removeProjectInput(projectKey)" class="icon mif-folder-minus fg-red pull-right" style="padding-right:10px;cursor:pointer;"></span></div>
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-folder-special fg-amber"></span>
                                <input type="text" placeholder="Describe Briefly This Client Project" v-model="project.name">
                                <span class="fg-red" v-show="registerForm.errors.has(`projects.${projectKey}.name`)">
                                @{{ registerForm.errors.get(`projects.${projectKey}.name`) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    </div>
    <div class="row" style="position: absolute;width: 100%;bottom:0;">
        <button type="submit" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#558b2f;">
            <strong>Update Client</strong>
        </button>
    </div>
    </form>
</modal>
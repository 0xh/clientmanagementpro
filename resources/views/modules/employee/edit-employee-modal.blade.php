<modal name="edit-employee-modal" :width="500" :height="550" draggable=".window-header">
        <form @submit.prevent="editEmployee()" role="form" class="">
        <div class="panel widget-box">
    
            <div class="heading" style="background-color:#4db6ac;">
                <div class="title window-header align-center">Edit @{{ registerForm.name }} <span @click="closeEditModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
            </div>
    
            <div class="content">
    
                    <div class="text">
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-user fg-lime"></span>
                                <input type="text" placeholder="Team Member Name" v-model="registerForm.name">
                                <span class="fg-red" v-show="registerForm.errors.has('name')">
                            @{{ registerForm.errors.get('name') }}
                            </span>
                            </div>
                        </div>
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-mail fg-yellow"></span>
                                <input type="text" placeholder="Team Member Email" v-model="registerForm.email">
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

                        <div class="row" style="padding:5px;">
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
                    </div>
            </div>
    
        </div>
        <div class="row" style="position: absolute;width: 100%;bottom:0;">
            <button type="submit" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#558b2f;">
                <strong>Update Team Member's Account</strong>
            </button>
        </div>
        </form>
    </modal>
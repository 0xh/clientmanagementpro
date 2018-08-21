<modal name="add-tenant-modal" :width="500" :height="550" draggable=".window-header">
        <form @submit.prevent="addTenant()" role="form" class="">
        <div class="panel widget-box">
    
            <div class="heading" style="background-color:#4db6ac;">
                <div class="title window-header align-center">Create New Tenant<span @click="closeAddTenantModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;cursor:pointer;"></span></div>
            </div>
    
            <div class="content">
    
                    <div class="text">
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-user fg-lime"></span>
                                <input type="text" placeholder="Name" v-model="registerForm.name">
                                <span class="fg-red" v-show="registerForm.errors.has('name')">
                            @{{ registerForm.errors.get('name') }}
                            </span>
                            </div>
                        </div>
    
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span class="prepend-icon mif-mail fg-yellow"></span>
                                <input type="text" placeholder="Email" v-model="registerForm.email">
                                <span class="fg-red" v-show="registerForm.errors.has('email')">
                            @{{ registerForm.errors.get('email') }}
                            </span>
                            </div>
                        </div>
                        
                        <div class="row" style="padding:5px;">
                            <div class="input-control text full-size">
                                <span v-if="registerForm.hidden" class="prepend-icon mif-spell-check fg-darkCyan" @click="registerForm.hidden = false"></span>
                                <span v-else class="prepend-icon mif-eye fg-darkCyan" @click="registerForm.hidden = true"></span>
                                <input v-if="registerForm.hidden" type="password" placeholder="Password" v-model="registerForm.password">
                                <input v-else type="text" placeholder="Password" v-model="registerForm.password">
                                <span class="fg-red" v-show="registerForm.errors.has('password')">
                            @{{ registerForm.errors.get('password') }}
                            </span>
                            </div>
                        </div>
                        <div  class="row" style="padding:5px;margin-top:25px;">
                                <div class="input-control text full-size">
                                    <label class="switch pull-left">
                                        <input type="checkbox" v-model="registerForm.sendEmail">
                                        <span class="check"></span>
                                        <span class="caption" v-if="!registerForm.sendEmail"><span class="tag info">Do You Want To Send Welcome Email?</span></span>
                                        <span class="caption" v-else><span class="tag success">Send Welcome Email</span></span>
                                    </label>
                                    
                                </div>
                        </div>
                        <div  class="row" style="padding:5px;margin-top:-30px;">
                                <div class="input-control text full-size">
                                    <label class="switch pull-left">
                                        <input type="checkbox" v-model="registerForm.lifetime">
                                        <span class="check"></span>
                                        <span class="caption" v-if="!registerForm.lifetime"><span class="tag info">Create Lifetime User?</span></span>
                                        <span class="caption" v-else><span class="tag success">Create Lifetime User</span></span>
                                    </label>
                                </div>
                        </div>
                    </div>
            </div>
    
        </div>
        <div class="row" style="position: absolute;width: 100%;bottom:0;">
            <button type="submit" class="button fg-white" :class="{'bg-teal': !registerForm.busy,'bg-red': registerForm.busy}" style="width:500px; margin-bottom:-1px;" :disabled="registerForm.busy">
                <strong v-if="!registerForm.busy">Create New Tenant</strong>
                <strong class="icon mif-spinner mif-ani-spin" v-else></strong>
            </button>
        </div>
        </form>
    </modal>
<div class="frame" id="uploaded_tab">
        <!-- Uses Vue Component file-upload -->
    <uploaded-files :tenant="tenant" :guard="guard"  inline-template>
        <div>
            <div class="section-wrapper align-center fg-white">
                <h3 v-show="files.length >0">Manage Your Uploads</h3>
            </div>
            <div v-if="files.length >0" class="section-wrapper animated fadeInRightBig">
                <div class="grid">
                    <div class="row cells3" v-for="(item, itemKey) in fileChunks(files)" :key="itemKey">
                        <div class="cell gallery" v-for="(file,fileKey) in item" :key="fileKey">
                            <div class="image">
                                <div class="image-inner crop">
                                        <a :href="getSourceFile(file)">
                                            <img  :src="getImageByExtension(file)" alt="" class="portrait"/>
                                        </a>
                                        <p class="image-caption">
                                                {{ file.name }}
                                        </p>
                                    
                                </div>
                                <div class="image-info">
                                    <h5 class="title">{{ file.name }}</h5>
                                    <div class="row">
                                        <span>Uploaded By: </span> <a style="cursor:pointer;">  {{ file.uploadable.name }}</a>
                                    </div>
                                    <div class="row cells2" style="min-height:35px; padding-top:5px;cursor:pointer;">
                                        <div class="cell bg-blue align-center sub-alt-header" @click="showEditFileModal(file)">
                                            <a href="#!" class="fg-white" style="vertical-align:middle;">
                                                <span class="mif-pencil"></span> Edit
                                            </a>
                                        </div>
                                        <div class="cell bg-red align-center sub-alt-header" @click="showDeleteFileModal(file)">
                                            <a href="#!" class="fg-white" style="vertical-align:middle;">
                                                <span class="mif-bin"></span> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <modal name="edit-file-modal">
                                <div class="panel widget-box">
                                    <div class="heading">
                                        <div class="title">Edit {{fileEditForm.name}} <span @click="closeEditFileModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
                                    </div>
                                    <div class="content">
                                        <form @submit.prevent="editFile()" role="form" class="padding10">
                                            <div class="row">
                            
                                                <div class="input-control text full-size">
                                                <input type="text" placeholder="Edit" v-model="fileEditForm.name"></input>
                                                    <button type="submit" class="button info" :disabled="fileEditForm.busy">
                                                        <span class="icon mif-keyboard-return" v-if="!fileEditForm.busy"></span>
                                                        <span class="icon mif-spinner mif-ani-spin" v-else></span>
                                                    </button>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                            <span class="fg-red" v-show="fileEditForm.errors.has('name')">
                                                {{ fileEditForm.errors.get('name') }}
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </modal>
                            <modal name="delete-file-modal" :width="500" :height="250" draggable=".window-header">
                                <div class="panel widget-box">
                            
                                    <div class="heading" style="background-color:#4db6ac;">
                                        <div class="title window-header align-center">Confirm File Deletion </div>
                                    </div>
                            
                                    <div class="content">
                            
                                            <div class="text align-center">
                                                    <span class="icon mif-warning fg-amber" style="font-size: 5em;"></span> 
                                                    <h3 class="fg-amber">This Process is Irreversible</h3>                        
                                            </div>
                                    </div>
                            
                                </div>
                                <div class="row" style="position: absolute;width: 100%;bottom:0;">
                                    <button @click="deleteFile()" type="button" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#b71c1c;">
                                        <strong class="icon mif-bin"> Confirm</strong>
                                    </button>
                                    <button @click="closeDeleteFileModal()" type="button" class="button fg-white" style="width:500px; margin-bottom:-1px;background-color:#4db6ac;">
                                        <strong class="icon mif-not"> Cancel</strong>
                                    </button>
                                </div>
                            </modal>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="align-center v-align-middle">
                <h1 class="fg-white">No Files Uploaded Yet.</h1>
            </div>
        </div>
    </uploaded-files>
</div>
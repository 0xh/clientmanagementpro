<div v-if="guard === 'web'" class="frame bg-white" id="edit_tab"  style="min-height:600px;padding-bottom:100px;">
                
        <div style="min-height:500px;padding-bottom:100px;">
                <a @click="updateDescription()" style="position:absolute;top:0;right:17px;font-size:1em;cursor:pointer;">
                        <span class="tag info"><span class="icon mif-pencil"></span> Update Task Description</span>
                </a>
                <trumbowyg :config="configs.advanced" v-model="subtask.description"></trumbowyg>
        </div>
</div>

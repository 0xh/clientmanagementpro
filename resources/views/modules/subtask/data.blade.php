@push('critical_css')
<style>
blockquote {
    margin: 0;
    padding: 0 0 0 0;
    border-left: 0.1rem #4db6ac solid;
}
</style>
@endpush
<div class="frame bg-white" id="view_tab">
    <div class="example">
        <blockquote class="align-center fg-teal">
            <strong><h2 title="Source Title">@{{ subtask.name }}</h2></strong>
        </blockquote>
        
        <a style="position:absolute;top:0;right:0;font-size:1em;">
            <span class="tag bg-green fg-white" v-if="subtask.done"><span class="icon mif-checkmark"></span> DONE</span>
            <span class="tag bg-red fg-white" v-else-if="overDueDate(subtask)">Overdue @{{ subtask.due_date |date }}</span>
            <span class="tag bg-amber fg-white" v-else>Deadline: @{{ subtask.due_date|date }}</span>
        </a>
        
        <div class="align-center">
        <a> <star-rating :inline="true" :read-only="guard !== 'web'" @rating-selected="setRating" v-model="subtask.priority" :star-size="23" :show-rating="false"></star-rating></a>
        </div>
    </div>
    <div class="example align-right" v-if="guard ==='web'">
            <a v-if="guard ==='web'" @click="editTaskModal()" class="margin10">
                <!-- Open Modal To Edit Task -->
                <button class="button info"><span class="mif-pencil"></span> Edit Task</button>
            </a>
            <a v-if="guard ==='web'" @click="show('delete-subtask-modal')" class="margin10">
                <button class="button bg-lightRed fg-white"><span class="icon fa fa-trash "></span> Delete Task</button>
            </a>
            <a v-if="guard ==='web' && !showEditor" @click="openEditor()" class="margin10">
                <button class="button bg-cyan fg-white" :disabled="subtaskForm.busy"><span class="icon mif-keyboard"></span> Open Editor</button>
            </a>
            <a v-if="guard ==='web' && showEditor"  @click="editDescription()" class="margin10">
                <button class="button bg-lime fg-white" :disabled="subtaskForm.busy"><span class="icon mif-cloud-upload"></span> Save</button>
            </a>
    </div>
    <div v-if="showEditor && guard === 'web'" style="min-height:500px;padding-bottom:100px;">
            <trumbowyg :config="configs.advanced" v-model="subtask.description"></trumbowyg>
    </div>
    <div v-else class="example" v-html="subtask.description"></div>
    
    
</div>
    
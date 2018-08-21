@push('critical_css')
<style>
blockquote {
    margin: 0;
    padding: 0 0 0 2rem;
    border-left: 0.1rem #4db6ac solid;
}
</style>
@endpush
<div class="frame bg-white" id="job_tab">
<div class="example">
    <blockquote class="place-left">
        <p class="header fg-grayLight">@{{ taskForm.task_name }}</p>
    </blockquote>
    <!--
    <a @click="viewLink()" class="tag info place-right" v-if="taskForm.task_link">
        <span class="tag info">@{{ taskForm.task_link }}</span>
    </a>
    <a v-else @click="editTaskModal()" style="cursor:pointer;" class="place-right"><span class="tag info">Edit Job</span></a>
    -->
    <a v-if="taskForm.task_recurring" style="position:absolute;bottom:0;right:35px;font-size:1em;">
        <span class="tag success"><span class="icon mif-loop"></span> Repeat Job Every @{{ taskForm.task_interval }} Day</span>
    </a>
</div>
<div class="example align-right" v-if="guard ==='web'">
    <a v-if="guard ==='web'" @click="editTaskModal()" class="margin10">
        <!-- Open Modal To Edit Task -->
        <button class="button info"><span class="mif-pencil"></span> Edit Job</button>
    </a>
    <a v-if="guard ==='web'" @click="deleteTaskModal()" class="margin10">
        <button class="button bg-lightRed fg-white"><span class="icon fa fa-trash "></span> Delete Job</button>
    </a>
    <a v-if="guard ==='web' && !showEditor" @click="openEditor()" class="margin10">
        <button class="button bg-cyan fg-white" :disabled="taskForm.busy"><span class="icon mif-keyboard"></span> Open Editor</button>
    </a>
    <a v-if="guard ==='web' && showEditor"  @click="editDescription()" class="margin10">
        <button class="button bg-lime fg-white" :disabled="taskForm.busy"><span class="icon mif-cloud-upload"></span> Save</button>
    </a>
</div>

<div v-if="!showEditor" class="example" v-html="taskForm.task_description" v-if="taskForm.task_description"></div>


<div v-if="showEditor && guard ==='web'" style="min-height:500px;padding-bottom:100px;">
    <text-editor :description="taskForm.task_description"></text-editor>
</div>

</div>

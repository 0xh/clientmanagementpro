<div class="">
    <ul class="breadcrumbs fg-amber dark bg-teal" v-if="guard === 'employee'">
        <li><a :href="`/team/dashboard`"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a :href="`/team/dashboard/clients/${project.id}`">@{{ project.name }}</a></li>
        <li><a :href="`/team/dashboard/jobs/${task.id}`">@{{ task.name }}</a></li>
        <li><a :href="`/team/dashboard/tasks/${subtask.id}`">@{{ subtask.name }}</a></li>
    </ul>
    <ul class="breadcrumbs fg-amber dark bg-teal" v-else-if="guard === 'client'">
        <li><a :href="`/client/dashboard`"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a :href="`/client/dashboard/clients/${project.id}`">@{{ project.name }}</a></li>
        <li><a :href="`/client/dashboard/jobs/${task.id}`">@{{ task.name }}</a></li>
        <li><a :href="`/client/dashboard/tasks/${subtask.id}`">@{{ subtask.name }}</a></li>
    </ul>
    <ul class="breadcrumbs fg-amber dark bg-teal" v-else>
        <li><a :href="`/dashboard`"><span class="icon mif-widgets fg-white"></span></a></li>
        <li><a :href="`/dashboard/clients/${project.id}`">@{{ project.name }}</a></li>
        <li><a :href="`/dashboard/jobs/${task.id}`">@{{ task.name }}</a></li>
        <li><a :href="`/dashboard/tasks/${subtask.id}`">@{{ subtask.name }}</a></li>
    </ul>
</div>
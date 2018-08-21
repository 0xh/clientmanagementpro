<div>
    <a href="#!" v-if="guard === 'web'">
        <button @click="showCampaignModal()" class="button info"><span class="mif-plus"></span> Add New Campaign</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="show('edit-project')" class="button info"><span class="mif-pencil"></span> Edit Client Project</button>
    </a>
    <a href="#!" v-if="guard === 'web'">
        <button @click="showDeleteProjectModal()" class="button alert"><span class="icon fa fa-trash"></span> Delete Client Project</button>
    </a>
</div>
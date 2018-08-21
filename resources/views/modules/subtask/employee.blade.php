@push('critical_css')
<style>
    div.dropdown-toggle::before {
        display:none;
    }

</style>
@endpush
<div class="frame bg-white" id="people_tab"  style="min-height:600px;padding-bottom:100px;">
    
    <div class="row" style="padding-top:100px;" v-if="guard === 'web'">
            <a v-if="guard === 'web'" @click="updateAssignedEmployees()" style="position:absolute;top:0;right:0;font-size:1em;cursor:pointer;">
                    <span class="tag info" style="font-size:1.5em;"><span class="icon mif-keyboard-return"></span> Update Team</span>
            </a>
            <v-select v-if="guard === 'web'" style="margin-bottom:50px;margin-top:-50px;" multiple max-height="160px" class="full-size" v-model="subtask.employees" label="email" :options="options"  placeholder="Assigned Existing Team Member"></v-select>
    </div>
    <div  class="row cells4" v-for="(chunk, chunkKey) in employeeChunks" :key="chunkKey">
        <div class="cell" v-for="(employee, employeeKey) in chunk" :key="employeeKey">
            <a   style="cursor:pointer;">
                <img :src="employee.photo_url" 
                    :alt="employee.name"
                    style="border: 2px solid #d3e0e9;
                        border-radius: 50%;
                        height: 40px;
                        padding: 2px;
                        width: 40px;
                        height: 50px;
                        width: 50px;"
                >
                @{{ employee.name }}
            </a>
        </div>
    </div>
    <div v-if="options.length < 1" class="row" style="min-height:450px;">
            <div class="cell align-center">
                <h4 class="fg-lightRed">You Dont Have Any Teammembers Create Yet</h4>
                <h4 class="tag bg-blue fg-white" style="cursor:pointer; font-size:20px;"><strong @click="goToTeam()">Create New Team Members Now</strong></h4>
            </div>
    </div>
</div>

@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer') 
<style>
.option-wrap {
    width: 110px;
}
.name-wrap {
    width: 220px;
}
.designation-wrap {
    width: 30%;
}
</style>
@endpush @section('content')
<vue-up></vue-up>
<employee-management :guard="{{ json_encode($guard) }}" :teams="{{ json_encode($employees) }}" :clients="projects" :user="user" inline-template>
<div>
    <div class="tabcontrol2 page-tab" data-role="tabcontrol" style="min-height:700px;padding-bottom:100px;">
            <ul class="tabs">
                <li>
                    <a href="#employee_list">Teammates</a>
                </li>
            </ul>
            <div class="frames bg-white">
                <div class="padding10"></div>
                <div id="employee_list">
                    <div class="section-wrapper animated fadeInRightBig">
                        <div class="panel widget-box">
                            <div class="heading">
                                <div class="title">Manage Teammates</div>
                            </div>
                            <div class="content">
                                <div class="text">
                                        <button @click="showAddEmployeeModal()" class="button small-button primary create-item">Add Teammate</button>
                                        <div class="table-responsive" v-if="employees.length >0">
                                            <table class="table border bordered striped ">
                                                <thead class="">
                                                    <tr>
                                                        <th class="name-wrap">Name</th>
                                                        <th class="align-left">Email</th>
                                                        <th>Job Assignments</th>
                                                        <th class="option-wrap">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(employee,employeeKey,employeeIndex) in employees" :key="employeeKey" :index="employeeIndex">
                                                        <td>@{{ employee.name }}</td>
                                                        <td class="align-left">@{{ employee.email }}</td>
                                                        <td class="align-left">
                                                            <ul  class="tag info"  v-for="(task,taskKey,taskIndex) in employee.tasks" :key="taskKey" :index="taskIndex" style="cursor:pointer;list-style-type: none;">
                                                                <li @click="viewAssignedSubtask(employee,task)"><span class="icon mif-tag"></span>  @{{ task.name }}</li>
                                                            </ul>
                                                        </td>
        
                                                        <td class="align-left">
                                                            <span class="tag info" @click="showEditModal(employee,employeeKey)" style="cursor:pointer;">
                                                                <span class="icon mif-pencil">
                                                                </span>
                                                            </span>
                                                            <span class="tag alert" @click="showDeleteModal(employee,employeeKey)" style="cursor:pointer;"> 
                                                                <span class="icon fa fa-trash">
                                                                    
                                                                </span>
                                                            </span>
                                                        </td>
                                                        
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <div v-else class="align-center v-align-middle" style="min-height: 500px; padding-top:100px;">
                                                <h2 class="fg-teal"><span class="tag success" @click="showAddEmployeeModal()" style="cursor:pointer;">Add Your First Team Member</span></h2>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @include('employee::project-subtasks-modal')
    @include('employee::add-employee-modal')
    @include('employee::edit-employee-modal')
    @include('employee::delete-employee-modal')
</div>
</employee-management>

@endsection

@push('footer_js')

@endpush
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
<client-management :guard="{{ json_encode($guard) }}" :projectlist="{{ json_encode($projectlist) }}" :clientlist="{{ json_encode($clientlist) }}" :user="user" inline-template>
<div>
    <div class="tabcontrol2 page-tab" data-role="tabcontrol" style="min-height:700px;">
            <ul class="tabs">
                <li>
                    <a href="#client_list">Clients</a>
                </li>
            </ul>
            <div class="frames bg-white">
                <div class="padding10"></div>
                <div id="client_list">
                    <div class="section-wrapper animated fadeInRightBig">
                        <div class="panel widget-box">
                            <div class="heading">
                                <div class="title">Manage Client's Account</div>
                            </div>
                            <div class="content">
                                <div class="text">
                                        <button @click="showAddClientModal()" class="button small-button primary create-item">Add New Client Account</button>
                                        <div class="table-responsive" v-if="clients.length > 0">
                                            <table class="table border bordered striped ">
                                                <thead class="">
                                                    <tr>
                                                        <th class="name-wrap">Name</th>
                                                        <th class="align-left">Website</th>
                                                        <th class="align-left">Email</th>
                                                        <th>Client Projects</th>
                                                        <th class="option-wrap">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(client,clientKey,clientIndex) in clients" :key="clientKey" :index="clientIndex">
                                                        <td>@{{ client.name }}</td>
                                                        <td>@{{ client.website }}</td>
                                                        <td class="align-left">@{{ client.email }}</td>
                                                        <td class="align-left">
                                                            <ul  class="tag success"  v-for="(project,projectKey,projectIndex) in client.projects" :key="projectKey" :index="projectIndex" style="cursor:pointer;list-style-type: none;">
                                                                <li @click="viewProject(project.id)"><span class="icon mif-tag"></span>  @{{ project.name }}</li>
                                                            </ul>
                                                        </td>
        
                                                        <td class="align-left">
                                                            <span class="tag info" @click="showEditModal(client,clientKey)" style="cursor:pointer;">
                                                                <span class="icon mif-pencil">
                                                                </span>
                                                            </span>
                                                            <span class="tag alert" @click="showDeleteModal(client,clientKey)" style="cursor:pointer;"> 
                                                                <span class="icon fa fa-trash">
                                                                    
                                                                </span>
                                                            </span>
                                                        </td>
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div v-else class="align-center v-align-middle" style="min-height: 500px; padding-top:100px;">
                                                <h2 class="fg-teal"><span class="tag success" @click="showAddClientModal()" style="cursor:pointer;">Add Your First Client</span></h2>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @include('client::add-client-modal')
    @include('client::edit-client-modal')
    @include('client::delete-client-modal')
</div>
</client-management>

@endsection

@push('footer_js')

@endpush
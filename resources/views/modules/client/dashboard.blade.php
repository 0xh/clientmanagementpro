@extends('evolutly::layouts.dashboard')
@push('critical_css')
@include('css::grid')
@include('css::footer')
@endpush
@section('content')
<vue-up></vue-up>
<dashboard :guard="{{ json_encode($guard) }}" :tenant="tenant" :clientlist="clients" :user="user" :projectlist="projects" inline-template>
<div>
    <div class="section-wrapper page-heading">

        <div>
            <h2 class="place-left alight-left fg-amber">Welcome! @{{ user.name }}</h2>
        </div>

        <div class="place-right align-right" v-if="guard === 'web'" style="position:relative; top: 10px; right: 10px;">
            <a href="#!">
                <button @click="show('add-project')" class="button info"><span class="mif-plus"></span> Add New Client</button>
            </a>
        </div>

    </div>

    <div class="section-wrapper bg-grayLighter align-center" style="margin-top:100px;">
        <h1 v-show="projects.length >0" v-if="guard != 'client'">Clients</h1>
        <h1 v-else>Your Projects</h1>
    </div>
        
    <div v-if="projects.length >0" class="section-wrapper animated fadeInRightBig margin-bottom-40">
        <div class="grid condensed demo-grid">
            <div class="row cells3" v-for="(chunk, index_chunk, key_chunk) in projectChunks(projects)" :chunk="chunk" :index="index_chunk" :key="key_chunk">
                <div class="cell" v-for="(project,index_project, key_project) in chunk" :project="project" :index="index_project" :key="key_project">
                    <div class="panel error">
                        <div class="heading">
                                <span v-if="canCloneProject(project)" class="title" @click="showEditProjectModal(project)">
                                    <span class="mif-pencil" style="padding-right:5px;cursor:pointer;"></span>
                                    @{{ project.name }}
                                </span>
                                <span v-else>@{{ project.name }}</span>
                                <span v-if="canCloneProject(project)" @click="deleteProject(project.id)" class="bg-red alert icon fa fa-trash" style="cursor:pointer;"
                                data-role="hint" data-hint-mode="2" data-hint="Project|Delete" data-hint-position="top"
                                ></span>
                                <div v-if="canCloneProject(project)">
                                    <span style="position:absolute;top:5px;right:5px;font-size:1.2em;cursor:pointer;" @click="toggleClonable(index_project,project)">
                                            <span  class="bg-red alert icon" :class="{'mif-stack3': isClonable(project), 'mif-stack2': !isClonable(project), 'fg-teal': isClonable(project), 'fg-white': !isClonable(project) }"
                                            data-role="hint" data-hint-mode="2" data-hint="Template|Add/Remove" data-hint-position="top"
                                            >
                                            </span>
                                    </span>
                                </div>
                        </div>
                        
                        <div class="content">
                            <div class="tile-container row cells2">
                                <div class="tile bg-amber fg-white cell" data-role="tile" @click="viewProject(project.id)">
                                    <div class="tile-content iconic cell">
                                        <span class="icon fa fa-flag"></span>
                                        <span class="tile-badge bg-lightOrange" style="margin-right: -14px; margin-bottom: 2px;">@{{ project.campaigns_count }}</span>
                                        <span class="tile-label">Campaigns</span>
                                    </div>
                                </div>

                                <div class="tile bg-teal fg-white cell element-selected" data-role="tile" @click="viewProgress(project.id,project.slug)">
                                    <div class="tile-content iconic cell">
                                        <span class="icon fa fa-tasks"></span>
                                        <div class="tile-label">Progress</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    @include('project::view-progress-modal')
                </div>
            </div>
            
        </div>
    </div>
    <div v-else class="align-center v-align-middle" style="min-height: 500px; padding-top:100px;" :class="styling">
        <h2 class="fg-teal"><span class="tag success" @click="goToTemplates()" style="cursor:pointer;">Choose a Prebuilt Template For Your Client</span> <span class="tag bg-taupe fg-white">OR</span> <span class="tag info" @click="show('add-project')" style="cursor:pointer;">Create From Scratch</span></h2>
    </div>
    @include('project::add-project-modal')
    @include('project::editProjectForm')
        
</div>
</dashboard>
@endsection
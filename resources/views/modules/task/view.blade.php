@extends('evolutly::layouts.dashboard') 

@push('critical_css')
@include('css::footer')
@include('css::progressbar')
<link href="https://unpkg.com/trumbowyg@2.7.0/dist/ui/trumbowyg.min.css" rel="stylesheet">
@endpush 

@section('content')
<!-- Section Wrapper -->
<vue-up></vue-up>
<task :guard="{{json_encode($guard)}}" :activities="{{json_encode($activities)}}" :campaign="{{ json_encode($campaign) }}" :client="{{json_encode($client)}}" :employees="employees" :tenant="tenant" :user="user" :task="{{json_encode($task)}}" :project="{{json_encode($project)}}" :workers="{{json_encode($workers)}}" inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <br>
    <!-- Panel box -->
    <div class="panel widget-box">
        <!-- Content -->
        <div class="content">
            @include('task::breadcrumbs')
            <!-- Div text -->
            <div class="text">
                
                <div class="row cells12">
                        <div class="tabcontrol" data-role="tabcontrol">
                            <ul class="tabs">
                                <li><a href="#job_tab">Job</a></li>
                                <li><a href="#tasks_tab">Tasks</a></li>
                                <li><a href="#people_tab">Team</a></li>
                                <!-- <li><a href="#calendar">Calendar</a></li> -->
                            </ul>
                            <div class="grid frames bg-white">
                                @include('task::data')
                                @include('subtask::tab')
                                @include('employee::tab')
                                {{-- @include('subtask::calendar') --}}
                            </div>
                        </div>
                </div>
            </div>
            <!-- Div text -->
        </div>
        <!-- Content -->
    </div>
    @include('task::edit-task-modal')
    @include('task::delete-task-modal')
    @include('subtask::add-subtask-modal')
    <!-- Panel box -->
</div>

<!-- Section Wrapper -->
</task>

@endsection
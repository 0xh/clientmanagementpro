@extends('evolutly::layouts.dashboard') 

@push('critical_css')
@include('css::footer')
@include('css::formbuilder')
@include('css::fraction')
@endpush

@push('header_js')

@endpush

@section('content')
<vue-up></vue-up>
<templates :guard="{{ json_encode($guard) }}" :templatelist="{{json_encode($templates)}}" :mytemplatelist="{{json_encode($mytemplatelist)}}" :tenant="tenant" :user="user" inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <div class="grid">
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="panel widget-box">
                    @include('template::breadcrumbs')
                    @include('template::content')
                </div>
            </div>
        </div>
    </div>
    <modal name="show-jobs-modal" width="50%" height="82%" :scrollable="true">
        <div class="panel widget-box" v-if="current_campaign">
            <div class="heading align-center">
                <div class="title">Jobs List For: @{{ current_campaign.name }}<span @click="closeJobsModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
            <div class="content">
                <div class="accordion" data-role="accordion">
                    <div class="frame active removeborder" v-for="(task, tKey, tIndex) in current_campaign.tasks" :key="tKey" :index="tIndex">
                        <div class="heading">Tasks For Job : @{{ task.name }}
                            <span class="icon mif-list" style="font-size:1.5em;position:absolute;top:5px;right:5px;"></span>
                        </div>
                        <div class="content">
                                <ol class="todo-list numeric-list" style="margin-top:-5px;">
                                <li v-for="(subtask,sKey,sIndex) in task.subtasks" :index="sIndex" :key="sKey">
                                    <span class="tag success" style="margin-top:-3px;">@{{ subtask.name }}</span>
                                </li>
                                </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
    <modal name="show-myjobs-modal" width="50%" height="82%" :scrollable="true">
        <div class="panel widget-box" v-if="mycurrent_campaign">
            <div class="heading align-center">
                <div class="title">Jobs List For: @{{ mycurrent_campaign.name }}<span @click="closeMyJobsModal()" class="icon fa  fa-remove fg-red" style="font-size: 3.3em; position:absolute; top:0px; right:0px; margin-top:-13px;"></span></div>
            </div>
            <div class="content">
                <div class="accordion" data-role="accordion">
                    <div class="frame active removeborder" v-for="(mytask, mytKey, mytIndex) in mycurrent_campaign.tasks" :key="mytKey" :index="mytIndex">
                        <div class="heading">Tasks For Job : @{{ mytask.name }}
                            <span class="icon mif-list" style="font-size:1.5em;position:absolute;top:5px;right:5px;"></span>
                        </div>
                        <div class="content">
                                <ol class="todo-list numeric-list" style="margin-top:-5px;">
                                <li v-for="(mysubtask,mysKey,mysIndex) in mytask.subtasks" :index="mysIndex" :key="mysKey">
                                    <span class="tag success" style="margin-top:-3px;">@{{ mysubtask.name }}</span>
                                </li>
                                </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </modal>
</div>
</templates>
@endsection

@push('footer_js')

@endpush
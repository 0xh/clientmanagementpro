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
<projects :guard="{{ json_encode($guard) }}" :employees="employees" :clientlist="clients" :tenant="tenant" :user="user" :project="{{ json_encode($project) }}" :campaignlist="{{ json_encode($campaigns) }}" :workers="{{ json_encode($workers) }}" inline-template>
<div class="section-wrapper animated fadeInRightBig">
    <div class="grid">
        <div class="row cells12">
            <div class="cell colspan12">
                <div class="panel widget-box">
                    @include('project::breadcrumbs')
                    @include('project::content')
                </div>
            </div>
        </div>
    </div>
<!-- ADD ALL MODALS HERE THAT IS NOT SPECIFIC FOR PROJECT OR CAMPAIGN -->
@include('project::edit-project-modal')
@include('project::delete-project-modal')
@include('campaign::add-campaign-modal')

<!-- Modal Specific For Creating Task -->
@include('task::add-task-modal')
</div>
</projects>
@endsection

@push('footer_js')

@endpush
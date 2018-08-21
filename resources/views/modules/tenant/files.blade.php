@extends('evolutly::layouts.app')

@push('critical_css')
@include('css::footer')
@include('css::crop')
@endpush

@section('content')
<file-management :tenant="tenant" :files="{{ json_encode($files) }}" :guard="{{ json_encode($guard) }}" inline-template>
<div>
    <div class="section-wrapper page-heading">
        
        <div>
            <h2 class="place-left alight-left fg-amber">Welcome! @{{ tenant.name }}</h2>
        </div>

        <div class="place-right align-right" v-if="guard === 'web'" style="position:relative; top: 10px; right: 10px;">
            <a href="#!">
                <button class="button info"><span class="mif-plus"></span> Upload New File</button>
            </a>
        </div>
        
    </div>
    <div class="section-wrapper bg-grayLighter align-center fg-blue" style="margin-top:100px;">
        <h3 v-show="files.length >0">Manage Your Uploads</h3>
    </div>
    <div v-if="files.length >0" class="section-wrapper animated fadeInRightBig">
        <div class="grid">
            <div class="row cells3" v-for="item in fileChunks(files)">
                <div class="cell gallery" v-for="file in item">
                    <div class="image">
                        <div class="image-inner crop">
                                <a :href="getSourceFile(file)">
                                    <img  :src="getImageByExtension(file)" alt="" class="portrait"/>
                                </a>
                                <p class="image-caption">
                                        @{{ file.name }}
                                </p>
                           
                        </div>
                        <div class="image-info">
                            <h5 class="title">@{{ file.name }}</h5>
                            <div class="row">
                                <span>Uploaded By: </span> <a style="cursor:pointer;">  @{{ file.uploadable.name }}</a>
                            </div>
                            <div class="row">
                                <span>Project: </span> <a style="cursor:pointer;">  @{{ file.project.name }}</a>
                            </div>
                            <div class="row cells2" style="min-height:35px; padding-top:5px;cursor:pointer;">
                                <div class="cell bg-blue align-center sub-alt-header" @click="editFile(file)">
                                    <a href="#!" class="fg-white" style="vertical-align:middle;">
                                        <span class="mif-pencil"></span> Edit
                                    </a>
                                </div>
                                <div class="cell bg-red align-center sub-alt-header" @click="deleteFile(file)">
                                    <a href="#!" class="fg-white" style="vertical-align:middle;">
                                        <span class="mif-bin"></span> Delete
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="align-center v-align-middle" style="min-height: 500px; padding-top:100px;" :class="styling">
        <h1 class="fg-teal">No Files Uploaded Yet.</h1>
    </div>
</div>
</file-management>
@endsection

@push('footer_js')

@endpush
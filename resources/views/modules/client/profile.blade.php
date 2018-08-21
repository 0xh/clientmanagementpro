@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer')
<style>
    .avatar {
        /* fill the container, preserving aspect ratio, and cropping to fit */
        background-size: cover;

        /* center the image vertically and horizontally */
        background-position: center;

        /* round the edges to a circle with border radius 1/2 container size */
        border-radius: 50%;
    }
</style>
@endpush @section('content')
<div class="section-wrapper margin-bottom-60 animated fadeInRightBig">
    <div class="grid">
        <div class="row cells">

            <div class="cell">

                <div class="panel widget-box">
                    <div class="heading">
                        <div class="title">Profile</div>
                    </div>
                    <div class="content margin-bottom-50">
                        <div class="sub-heading">Edit Your Profile</div>

                        <div class="text">
                            <div class="align-center padding10">
                                <a href="#" class="icon">
                                        <img src="{{$user->photo_url}}" class="avatar">
                                    </a>
                            </div>
                            <form class="form-horizontal" role="form" method="POST" action="{{ route('client.profile.update') }}">
                                {{ method_field('PUT') }} 
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>Name</label>
                                        <div class="input-control text full-size">
                                            <input type="text" name="name" placeholder="Your Full Name..." value="{{$user->name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>Email</label>
                                        <div class="input-control text full-size">
                                            <input type="text" name="email" placeholder="Your Best Email..." value="{{$user->email}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-container align-right">
                                    <button class="button caption info" name="submit" value="submit" data-form-builder="button">Update Profile</button>
                                </div>
                            </form>
                            <form enctype="multipart/form-data" class="form-horizontal" role="form" method="POST" action="{{ route('client.profile.upload') }}">
                                {{ method_field('PUT') }} 
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>Upload Photo</label>
                                        <div class="input-control file full-size" data-role="input">
                                            <input type="file" name="avatar">
                                            <button class="button"><span class="mif-folder"></span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-container align-right">
                                    <button class="button caption info" name="submit" value="submit" data-form-builder="button">Upload Avatar</button>
                                </div>
                            </form>

                        </div>

                        <!-- End Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
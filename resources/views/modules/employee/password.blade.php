@extends('evolutly::layouts.app')
@push('critical_css')
@include('css::grid')
@include('css::footer')
@endpush @section('content')
<div class="section-wrapper margin-bottom-60 animated fadeInRightBig">
    <div class="grid">
        <div class="row cells">

            <div class="cell">

                <div class="panel widget-box">
                    <div class="heading">
                        <div class="title">Security</div>
                    </div>
                    <div class="content margin-bottom-50">
                        <div class="sub-heading @if(isset($success)) bg-green @endif">
                            @if(isset($success)) 
                            {{$success}} 
                            @else 
                            Change Password 
                            @endif
                        </div>

                        <div class="text">

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('employee.password.change') }}">
                                {{ method_field('PUT') }} 
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>Old Password</label>
                                        <div class="input-control text full-size">
                                            <input type="password" name="current_password" placeholder="Type Your Old Password">
                                        </div>
                                    </div>
                                </div>
                                @if(isset($failed))
                                <p class="fg-red" style="padding-left:10px; margin-top:-40px;">{{$failed}}</p>
                                @endif @if($errors->first('current_password'))
                                <p class="fg-red" style="padding-left:10px; margin-top:-40px;">{{$errors->first('current_password')}}</p>
                                @endif
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>New Password</label>
                                        <div class="input-control text full-size">
                                            <input type="password" name="password" placeholder="Type You New Password">
                                        </div>
                                    </div>
                                </div>
                                @if($errors->first('password'))
                                <p class="fg-red" style="padding-left:10px; margin-top:-40px;">{{$errors->first('password')}}</p>
                                @endif
                                <div class="row">
                                    <div class="cell padding10">
                                        <label>Confirm New Password</label>
                                        <div class="input-control text full-size">
                                            <input type="password" name="password_confirmation" placeholder="Confirm Your New Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="input-container align-right">
                                    <button class="button caption info" name="submit" value="submit" data-form-builder="button">Change Password</button>
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
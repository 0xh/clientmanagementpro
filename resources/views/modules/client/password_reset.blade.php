@extends('layouts.front') 
@section('content')
<div class="page-container" style="height:100%;">
        <div class="container">
            <div class="grid no-margin-top">

                <div class="section-wrapper margin-bottom-60 animated fadeInRightBig">
                        <div class="grid">
                            <div class="row cells">
                                
                                <div class="cell">
                                    
                                    <div class="panel widget-box">
                                        <div class="heading align-center">
                                            <div class="title">Reset Your Password</div>
                                        </div>
                    
                                        <div class="content">
                                            <div class="sub-heading align-center">You May Reset Your Password</div>
                                            <div class="text">
                                            <form role="form" method="POST" action="{{ route('client.password.new_password') }}">
                                                {{ csrf_field() }}
                                                
                                                <div class="row cell">
                                                    <div class="cell">
                                                        <label>Email</label>
                                                        <input type="hidden" name="token" value="{{ $token }}">
                                                        <div class="input-control text full-size">
                                                            <input type="email" name="email" value="{{ request()->input('email') }}" readonly>
                                                        </div>
                                                        @if ($errors->has('email'))
                                                        <span class="fg-red">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                        </span> 
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row cell">
                                                    <div class="cell">
                                                        <label>New Password</label>
                                                        <div class="input-control text full-size">
                                                            <input type="password" name="password">
                                                        </div>
                                                        @if ($errors->has('password'))
                                                        <span class="fg-red">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                        </span> 
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row cell">
                                                    <div class="cell">
                                                        <label>Confirm New Password</label>
                                                        <div class="input-control text full-size">
                                                            <input type="password" name="password_confirmation">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row cell">
                                                    <div class="cell">
                                                            <button class="image-button small-button info pull-right">
                                                                    Reset Password
                                                                    <span class="icon mif-contacts-mail bg-lime"></span>
                                                            </button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
@endsection
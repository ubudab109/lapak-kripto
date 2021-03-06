@extends('auth.master',['menu'=>'dashboard'])
@section('title', 'Lapak Kripto')

@section('content')
    <div class="user-content-wrapper">
        <div>
            <div class="user-form">
                <div class="right">
                    <div class="form-top">
                        <a class="auth-logo" href="{{route('home')}}">
                            <img src="{{show_image(1,'login_logo')}}" class="img-fluid" alt="" style="width: 50%;">
                        </a>
                        {{--                    <h2>{{__('Login')}}</h2>--}}
                        <p>{{__('Log into your account')}}</p>
                    </div>
                    {{Form::open(['route' => 'loginProcess', 'files' => true])}}
                    <div class="form-group">
                        <label>{{__('Email address')}}</label>
                        <input type="email" value="{{old('email')}}" id="exampleInputEmail1" name="email"
                               class="form-control" placeholder="{{__('Your email here')}}">
                        @error('email')
                        <p class="invalid-feedback">{{ $message }} </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>{{__('Password')}}</label>
                        <input type="password" name="password" id="exampleInputPassword1"
                               class="form-control form-control-password look-pass-a"
                               placeholder="{{__('Your password here')}}">
                        @error('password')
                        <p class="invalid-feedback">{{ $message }} </p>
                        @enderror
                        <span class="eye"><i class="fa fa-eye-slash toggle-password"
                                             onclick="showHidePassword('old_password')"></i></span>
                    </div>
                    <div id="captcha" class="form-group"></div>
                    <div class="d-flex justify-content-between rememberme align-items-center mb-4">

                        <div class="mr-3"><a href="{{route('forgotPassword')}}">{{__('Forgot Password?')}}</a>
                        </div>
                        <div class=""><a href="{{route('resendVerification')}}">{{__('Resend Email Verification')}}</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary nimmu-user-sibmit-button">{{__('Login')}}</button>
                    {!!  GoogleReCaptchaV2::render('captcha') !!}
                    {{Form::close()}}
                    <div class="form-bottom text-center">
                        {{--                    <h4 class="or">OR</h4>--}}
                        {{--                    <div class="social-media">--}}
                        {{--                        <ul>--}}
                        {{--                            <li><a href="javascript:;" class="facebook"><i class="fa fa-facebook"></i></a></li>--}}
                        {{--                            <li><a href="javascript:;" class="twitter"><i class="fa fa-twitter"></i></a></li>--}}
                        {{--                            <li><a href="javascript:;" class="linkedin"><i class="fa fa-linkedin"></i></a></li>--}}
                        {{--                        </ul>--}}
                        {{--                    </div>--}}
                        <p>{{__("Don't have an account?")}} <a href="{{route('signUp')}}">{{__('Sign Up')}}</a></p>
                    </div>
                    {{-- <div class="default-access-wrapper">
                        <div class="auth-btn user">{{__('User Login')}}</div>
                        <div class="auth-btn admin">{{__('Admin Login')}}</div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')


    <script>
        $(".toggle-password").click(function () {
            $(this).toggleClass("fa-eye-slash fa-eye");
        });

        $(".eye").on('click', function () {
            var $pwd = $(".look-pass-a");
            if ($pwd.attr('type') === 'password') {
                $pwd.attr('type', 'text');
            } else {
                $pwd.attr('type', 'password');
            }
        });
    </script>
@endsection

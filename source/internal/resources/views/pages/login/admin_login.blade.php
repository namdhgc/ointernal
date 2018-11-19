<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.5.4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>Admin Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/uniform/css/uniform.default.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <!-- <link href="{{ URL::asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" /> -->
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ URL::asset('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ URL::asset('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ URL::asset('assets/pages/css/login-2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />

        <style>
            #forget-form {
                display: none;
            }
        </style>

        <script>
            
            $(document).ready(function() {

                $(document).on('click', '#forget-password', function(){

                    $('#forget-form').attr('style', 'display: block');
                });

                $(document).on('click', '#back-btn', function(){

                    $('#forget-form').attr('style', 'display: none');
                });
            });
        </script>
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="#">
                <img src="{{ URL::asset('assets/pages/img/logo-big-white.png') }}" style="height: 70px;" alt="" /> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" action="{{ route('postLogin') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-title">
                    <span class="form-title">Xin chào.</span>
                    <span class="form-subtitle">Vui lòng đăng nhập.</span>
                </div>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Hãy nhập tên đăng nhập và mật khẩu. </span>
                </div>
                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(Session::get('message')!='' && Session::get('message')!=null)
                <div class="alert {{ (Session::get('message')['meta']['code'] == 200) ? 'alert-success' : 'alert-danger' }}">
                    @if( isset(Session::get('message')['meta']['msg']))
                    <h4> {{ Session::get('message')['meta']['msg'][0] }} </h4>
                    @endif
                </div>
                @endif

                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Tên đăng nhập</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Tên đăng nhập" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Mật khẩu</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Mật khẩu" name="password" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn green btn-block uppercase">Đăng nhập</button>
                </div>
                <div class="form-actions">
                    <div class="pull-left">
                        <label class="rememberme check">
                            <input type="checkbox" name="remember" value="1" />Ghi nhớ </label>
                    </div>
                    <div class="pull-right forget-password-block">
                        <a href="javascript:;" id="forget-password" class="forget-password">Quên mật khẩu?</a>
                    </div>
                </div>
                
            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form id="forget-form" action="{{ URL::Route('request-reset-password') }}" method="post">
                <div class="form-title">
                    <span class="form-title">Quên mật khẩu ?</span>
                    <span class="form-subtitle">Hãy nhập email của bạn để gửi yêu cầu thay đổi mật khẩu.</span>
                </div>
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-default">Back</button>
                    <button type="submit" class="btn green btn-primary uppercase pull-right">Submit</button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            
            <!-- END REGISTRATION FORM -->
        </div>
        <!-- END LOGIN -->
        <!--[if lt IE 9]>
<script src="{{ URL::asset('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::asset('assets/global/plugins/excanvas.min.js') }}"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ URL::asset('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ URL::asset('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset('assets/pages/scripts/login.min.js') }}" type="text/javascript"></script>

        <script src="{{ URL::asset('js/lib/helper.js') }}" type="text/javascript"></script>
        <script src="{{ URL::Asset('js/lib/function.js') }}" type="text/javascript"></script>
        <script src="{{ URL::Asset('js/lib/spr.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('js/lib/validate.js') }}" type="text/javascript"></script>

        <script>
            $(document).ready(function(){

                var form  = $('#forget-form');
                var rules = {

                    email: {
                        required: true,
                        email: true
                    },
                }
                Validate.base_validate(form, rules);
            });

            jQuery.extend(jQuery.validator.messages, {
                required: "Trường này là bắt buộc.",
                email: "Hãy điền đúng định dạng email.",
                
            });
        </script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>
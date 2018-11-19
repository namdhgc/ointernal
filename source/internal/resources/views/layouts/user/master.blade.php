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
<!--[if IE 8]> <html lang="en" class="ie8 no-')}}"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-')}}"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <link rel="icon" href="{{ URL::asset('image/favicon.ico')}}" type="image/x-icon"/>
        <link href="{{ URL::asset('css/style_front.css') }}" rel="stylesheet">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/font-awesome/css/font-awesome.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/simple-line-icons/simple-line-icons.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap/css/bootstrap.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/uniform/css/uniform.default.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')}}"rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/morris/morris.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/jqvmap.css')}}"rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ URL::asset('assets/global/css/components.min.css')}}"rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ URL::asset('assets/global/css/plugins.min.css')}}"rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ URL::asset('assets/layouts/layout3/css/layout.min.css')}}"rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/layouts/layout3/css/themes/default.min.css')}}"rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ URL::asset('assets/layouts/layout3/css/custom.min.css')}}"rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->

        <!-- brgin date time -->
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css') }}" />
        {{-- <link href="{{ URL::asset('assets/css/helper.css') }}" rel="stylesheet" type="text/css"> --}}
        <!-- end date time -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
        @yield('css')
    <!-- END HEAD -->

    <body class="page-container-bg-solid page-boxed">
        <!-- BEGIN HEADER -->
        @include('layouts.user.header')
        <!-- END HEADER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <!-- BEGIN PAGE HEAD-->
                @include('layouts.user.page_head')    
                <!-- END PAGE HEAD-->
                <!-- BEGIN PAGE CONTENT BODY -->
                <div class="page-content">
                    <div class="container">
                    @yield('content')
                    </div>
                </div>
                <!-- END PAGE CONTENT BODY -->
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        @include('layouts.user.footer')
        <!-- END FOOTER -->
        <!--[if lt IE 9]>
<script src="{{ URL::asset('assets/global/plugins/respond.min.js')}}></script>
<script src="{{ URL::asset('assets/global/plugins/excanvas.min.js')}}></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ URL::asset('assets/global/plugins/jquery.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap/js/bootstrap.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/js.cookie.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery.blockui.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/uniform/jquery.uniform.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ URL::asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js')}}" type="text/javascript"></script> --}} 
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js')}}" type="text/javascript"></script> --}}
        {{-- <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js')}}" type="text/javascript"></script> --}}
        <script src="{{ URL::asset('assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ URL::asset('assets/global/scripts/app.min.js')}}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ URL::asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ URL::asset('assets/layouts/layout3/scripts/layout.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/layouts/layout3/scripts/demo.min.js')}}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/layouts/global/scripts/quick-sidebar.min.js')}}" type="text/javascript"></script>

        <!-- begin date time picker script -->
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/pages/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/global/plugins/clockface/js/clockface.js') }}" type="text/javascript"></script>
        <!-- end date time picker script -->

        <script src="{{ URL::asset('assets/js/helper.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('js/jquery.validate.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('js/messages_vi.js') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('assets/js/message_vi.js') }}"></script>

        @yield('js')

        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>
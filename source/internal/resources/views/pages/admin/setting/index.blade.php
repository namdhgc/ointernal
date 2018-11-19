 @extends('layouts/admin/master')

@section('title')
    {{ Lang::get('admin/sidebar.setting') }}
@endsection

@section('css')
    <link href="{{ URL::asset('assets/global/plugins/datatables/datatables.min.css" rel="stylesheet') }}" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <style type="text/css" >

        th.sorting*>a {
            display: block;
            width: 100%;
        }
        th.un-sort>a, th.sorting>a, th.sorting_asc>a, th.sorting_desc>a {
            text-decoration: none;
            color: black;
        }
        th.un-sort>a:hover, th.un-sort>a:focus,th.sorting>a:hover, th.sorting>a:focus, th.sorting_asc>a:hover, th.sorting_asc>a:focus, th.sorting_desc>a:hover, th.sorting_desc>a:focus{
            color: black;
        }
        th>a>p {
            margin: 0px !important;
        }
        #table-permission-role tr td, #table-permission-role tr th{
            max-width: 90px;
            min-width: 90px;
            word-wrap: break-word;
            text-align: center !important;
        }

        @media screen and (max-width: 900px) {
            #table-permission-role tr td:first; {
                text-align: left !important;
            }
        }
        [data-icon]:before {
            content : "" !important;
            display: none;
        }

        .help-block{
            color: red;
            opacity: 0.7;
        }
    </style>
@endsection

@section('js')

    <!-- Datatable js -->
    <script src="{{ URL::asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/pages/scripts/table-datatables-responsive.min.js') }}" type="text/javascript"></script>
    <!--End Datatable js -->
    <script src="{{ URL::asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>


    <script src="{{ URL::asset('js/lib/helper.js') }}" type="text/javascript"></script>
    <script src="{{ URL::Asset('js/lib/function.js') }}" type="text/javascript"></script>
    <script src="{{ URL::Asset('js/lib/spr.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/lib/validate.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/manage/setting/update_setting.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('js/manage/setting/update_allowed_ip_address.js') }}" type="text/javascript"></script>

    <script>
        Spr.init();
        UpdateSetting.init();
        UpdateAllowedIpAddress.init();


    </script>

    <script type="text/javascript">
            var cur_tab = localStorage.current_tab_setting;

            if (cur_tab == undefined || cur_tab == "" || $('.nav-tabs li a[href="'+cur_tab+'"]').length == 0) {

                cur_tab = "#tab_1";

            }

            $('.nav-tabs li').removeClass('active');
            $('.nav-tabs li a[href="'+cur_tab+'"]').first().parent('li').first().addClass('active');
            $('.tab-pane').removeClass('in active');
            $(cur_tab).addClass('in active');

            $(document).ready(function() {

                $(document).on('click', '.tab', function () {

                    var current_tab = $(this).attr('href');

                    localStorage.setItem("current_tab_setting", current_tab);
                });

            });
    </script>

@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">

            <!-- BEGIN PAGE BASE CONTENT -->
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-social-dribbble font-purple-soft"></i>
                                <span class="caption-subject font-purple-soft bold uppercase">{{ Lang::get('admin/setting.setting_title') }}</span>
                            </div>
                            <div class="actions">

                            </div>
                        </div>
                        <div class="portlet-body">
                            <ul class="nav nav-tabs">
                                <li class="">
                                    <a href="#tab_1" data-toggle="tab" class="tab" aria-expanded="true"> {{ Lang::get('admin/setting.basic_information') }} </a>
                                </li>
                                <li class="">
                                    <a href="#tab_2" data-toggle="tab" class="tab" aria-expanded="true"> {{ Lang::get('admin/setting.allowed_ip_address') }} </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade" id="tab_1">
                                    <section class="home-feature-block">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- BEGIN SAMPLE TABLE PORTLET-->
                                                <div class="portlet box green">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-social-dribbble font-white"></i>
                                                            <span class="caption-subject font-white bold uppercase">{{ Lang::get('admin/setting.company_information') }}</span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="expand">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">

                                                        @if(Session::get('message')!='' && Session::get('message')!=null)
                                                        <div class="alert {{ (Session::get('message')['meta']['code'] == 200) ? 'alert-success' : 'alert-danger' }}">
                                                            <h5> {{ Session::get('message')['meta']['msg'] }} </h5>
                                                        </div>
                                                        @endif

                                                        <form action="{{ URL::Route('adm-post-update-company-info') }}" method="POST" class="form-horizontal form-bordered" id="form-update-setting" enctype="multipart/form-data">

                                                            @if( isset($data) )
                                                            <input type="hidden" name="icon" id="icon"  value=" <?php echo isset($data['response']['logo']) ? $data['response']['logo']->icon:""?>">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <div class="form-body">
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold">{{ Lang::get('admin/setting.logo') }}</label>
                                                                    <div class="col-md-9">
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                                                @if(isset($data['response']['logo']))
                                                                                <img class="img-preview" name="path" src="{{ URL::asset( $data['response']['logo']->path ) }}">
                                                                                @else
                                                                                <img class="img-preview" name="path" src="">
                                                                                @endif
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn red btn-outline btn-file">
                                                                                    <span class="fileinput-new">{{ Lang::get('admin/setting.select') }}</span>
                                                                                    <span class="fileinput-exists"> {{ Lang::get('admin/setting.change') }} </span>
                                                                                    <input type="file" id="logo" name="image"> </span>
                                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">{{ Lang::get('admin/setting.remove') }}</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold">{{ Lang::get('admin/setting.company_name') }}</label>
                                                                    <div class="col-md-9">
                                                                         <input type="text" class="form-control com-info" id="company_name" name="company_name" value="{{ isset($data['response']['company_name']) ? $data['response']['company_name']->title : '' }}">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold">{{ Lang::get('admin/setting.email') }}</label>
                                                                    <div class="col-md-9">
                                                                         <input type="text" class="form-control com-info" id="email" name="email" value="<?php echo isset($data['response']['email']) ? $data['response']['email']->title:""?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold">{{ Lang::get('admin/setting.phone_number') }}</label>
                                                                    <div class="col-md-9">
                                                                         <input type="text" class="form-control com-info" id="phone_number" name="phone_number" value="<?php echo isset($data['response']['phone_number']) ? $data['response']['phone_number']->title:""?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold">{{ Lang::get('admin/setting.address') }}</label>
                                                                    <div class="col-md-9">
                                                                         <input type="text" class="form-control com-info" id="address" name="address" value="<?php echo isset($data['response']['address']) ? $data['response']['address']->title:""?>">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group form-md-line-input">
                                                                    <label class="control-label col-md-3 font-blue bold" for="description">{{ Lang::get('admin/setting.description') }}</label>
                                                                    <div class="col-md-9">
                                                                        <textarea class="form-control" id="description" name="description" rows="8" cols="5">{{ isset($data['response']['description']) ? $data['response']['description']->title : '' }}</textarea>
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                            @endif

                                                            <div class="form-footer">
                                                                <input type="submit" name="submit" value="{{ Lang::get('button.form.submit.title') }}" class="btn green {{ Lang::get('button.form.submit.class') }}">
                                                                <a href="javascript:;" class="btn default {{ Lang::get('button.form.cancel.class') }}">{{ Lang::get('button.form.cancel.title') }}</a>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- END SAMPLE TABLE PORTLET-->
                                            </div>
                                        </div>
                                    </section>
                                </div>


                                <div class="tab-pane fade" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- BEGIN EXAMPLE TABLE PORTLET-->

                                            <div class="portlet box green" id="search-tool">
                                                <div class="portlet-title">
                                                    <div class="caption">
                                                            <i class="icon-social-dribbble font-white"></i>
                                                            <span class="caption-subject font-white bold uppercase">{{ Lang::get('admin/setting.allowed_ip_address') }}</span>
                                                        </div>
                                                        <div class="tools">
                                                            <a href="javascript:;" class="expand">
                                                            </a>
                                                        </div>
                                                </div>
                                                <div class="portlet-body" >
                                                    @if(Session::get('message')!='' && Session::get('message')!=null)
                                                    <div class="alert {{ (Session::get('message')['meta']['code'] == 200) ? 'alert-success' : 'alert-danger' }}">
                                                        <h5> {{ Session::get('message')['meta']['msg'] }} </h5>
                                                    </div>
                                                    @endif

                                                    <form action="{{ URL::Route('adm-post-update-allowed-ip-address') }}" method="POST" id="form-update-allowed-ip-address">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <div class="tab-content clearfix">
                                                            <div class="form-group last col-md-6">
                                                                <div class="input">
                                                                    @if( isset($data) )
                                                                    <textarea rows="8" cols="5" class="form-control" name="allowed_ip_address" id="allowed_ip_address" value="" placeholder="{{ Lang::get('admin/setting.allowed_ip_address') }}">{{ isset($data['response']['allowed_ip_address']) ? $data['response']['allowed_ip_address']->title : '' }}</textarea>
                                                                    @endif
                                                                </div>
                                                                <span class="help-block">
                                                                    {{ Lang::get('admin/setting.help_allowed_ip_address') }}
                                                                </span>
                                                            </div>
                                                            <div class="form-group  col-md-12" >
                                                                <input type="submit" name="submit" value="{{ Lang::get('button.form.submit.title') }}" class="btn green {{ Lang::get('button.form.submit.class') }}">
                                                                <a href="javascript:;" class="btn default {{ Lang::get('button.form.cancel.class') }}">{{ Lang::get('button.form.cancel.title') }}</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- END EXAMPLE TABLE PORTLET-->
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END PAGE BASE CONTENT -->

        </div>
    </div>
</div>

@endsection
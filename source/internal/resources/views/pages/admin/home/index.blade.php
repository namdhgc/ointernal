@extends('layouts.admin.master')

@section('css')
<link href="{{ URL::asset('assets/global/plugins/bootstrap-toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<!-- <script src="{{ URL::asset('assets/pages/scripts/charts-amcharts.min.js') }}" type="text/javascript"></script> -->
<script src="{{ URL::asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::Asset('js/lib/helper.js') }}" type="text/javascript"></script>
<script src="{{ URL::Asset('js/lib/function.js') }}" type="text/javascript"></script>
<script src="{{ URL::Asset('js/lib/spr.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/custom-armchart.js') }}" type="text/javascript"></script>
<script>
    Spr.init();
    ChartsAmcharts.init();
</script>
@endsection

@section('content')
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEAD-->
        <div class="page-head">
            <!-- BEGIN PAGE TITLE -->
            <div class="page-title">
                <h1>Bảng điều khiển
                    <small>bảng điều khiển & thống kê</small>
                </h1>
            </div>
            <!-- END PAGE TITLE -->
           
        </div>
        <!-- END PAGE HEAD-->
        <!-- BEGIN PAGE BREADCRUMB -->
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ URL::Route('adm-index') }}">Trang chủ</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span class="active">Bảng điều khiển</span>
            </li>
        </ul>
        <!-- END PAGE BREADCRUMB -->
        <!-- BEGIN PAGE BASE CONTENT -->
        <!-- BEGIN DASHBOARD STATS 1-->
        
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->
        <div class="row">

        </div>
        
        <!-- BEGIN ROW -->
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN CHART PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject bold uppercase font-green-haze"> Biểu đồ thống kê số người đi muộn</span>
                            <span class="caption-helper"></span>
                        </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                            <!-- <a href="javascript:;" class="fullscreen"> </a> -->
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div id="late_time_chart" class="chart" data-url="{{ URL::Route('adm-ajax-data-chart') }}" style="height: 400px;"> </div>
                    </div>
                </div>
                <!-- END CHART PORTLET-->
            </div>
        </div>
        <!-- END ROW -->

        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div>
@endsection
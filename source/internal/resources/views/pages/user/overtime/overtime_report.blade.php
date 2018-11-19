@extends('layouts.user.master')

@section('title')
    {{Lang::get('user/overtime_report.overtime_report')}}
@endsection

@section('script')

@endsection

@section('content')



<div class="main-left">
    <center><label><legend class="titleStyle">{{Lang::get('user/overtime_report.overtime_report')}}</legend></label></center>
    <form id="tsReportForm" class="search_form" action="" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

        <div class="portlet box yellow">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>{{ Lang::get('user/timesheet_report.btnSearch') }}
                </div>

            </div>

            <div class="portlet-body">
                <div id="date_notification" style="color:#f44242"></div>
                <div class="floating-box">
                    <label class="h4">{{Lang::get('user/overtime_report.start_time')}}</label>
                    <div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                    <input type="text" class="form-control" readonly="" id="startDate" name="startDate" value="{{@$data['extra']['search_startDate']}}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="floating-box">
                    <label class="h4">{{Lang::get('user/overtime_report.end_time')}}</label>
                    <div class="input-group input-medium date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                    <input type="text" class="form-control" readonly="" id="endDate" name="endDate" value="{{@$data['extra']['search_endDate']}}">
                        <span class="input-group-btn">
                            <button class="btn default" type="button">
                                <i class="fa fa-calendar"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <br/>
                <button type="button" class="btn btn-warning btnStyle btn_reset">{{Lang::get('user/overtime_report.btnReset')}}</button>
                <button type="button" id="btn_search" class="btn btn-primary btnStyle">{{Lang::get('user/overtime_report.btnSearch')}}</button>
                <button type="button" id="btn_export" class="btn btn-success btnStyle">{{Lang::get('user/overtime_report.btnExport')}}</button>
            </div>
        </div>

    </form>
</div>
    @if(@$data['response']->total() > 0)
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>{{ Lang::get('user/timesheet_report.result') }}
            </div>

        </div>

        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-bordered response">
                <thead>
                    <tr align="center">
                        <th>{{Lang::get('user/overtime_report.em_id')}}</th>
                        <th>{{Lang::get('user/overtime_report.date')}}</th>
                        <th>{{Lang::get('user/overtime_report.start_time')}}</th>
                        <th>{{Lang::get('user/overtime_report.end_time')}}</th>
                        <th>{{Lang::get('user/overtime_report.department')}}</th>
                        <th>{{Lang::get('user/overtime_report.working_type')}}</th>
                        <th>{{Lang::get('user/overtime_report.note')}}</th>
                        <th>{{Lang::get('user/overtime_report.approver')}}</th>
                        <th>{{Lang::get('user/overtime_report.status')}}</th>
                        <th>{{Lang::get('user/overtime_report.approved_date')}}</th>
                        <!-- 
                        <th>{{Lang::get('user/overtime_report.day_time')}}</th>
                        <th>{{Lang::get('user/overtime_report.night_time')}}</th> 
                        -->
                    </tr>
                </thead>
                <tbody>
                @foreach(@$data['response'] as $dt)
                    <tr>
                        <td>{{@$dt->employee_id}}</td>
                        <td>{{@$dt->date}}</td>
                        <td>{{@$dt->startTime}}</td>
                        <td>{{@$dt->endTime}}</td>
                        <td>{{@$dt->name}}</td>
                        <td>{{@$dt->typeId}}</td>
                        <td>{{@$dt->note}}</td>
                        <td>{{@$dt->approverId}}</td>
                        <td>
                            <?php
                                echo ($dt->isApproved == 1) ? Lang::get('user/overtime_report.accepted') : Lang::get('user/overtime_report.pending')
                            ?>
                        </td>
                        <td>{{@$dt->approvedDate}}</td>
                        <!-- 
                        <td>{{@$dt->startTime}}</td>
                        <td>{{@$dt->endTime}}</td> 
                        -->
                    </tr>
                @endforeach

                </tbody>
                </table>
                {{@$data['response']->appends(array('startDate'=>Input::get('startDate'),'endDate'=>Input::get('endDate')))->links()}}
                @elseif(@$data['response']->total() <= 0)
                <h3 class="notification">{{ Lang::get('user/overtime_report.no_record') }}</h3>
                @endif
            </div>
        </div>
    </div>


</div>


@endsection

@section('js')
<script>
$(document).ready(function(){

    $("#btn_search").click(function(){

        $("#tsReportForm").attr("action", "overtimeReport");

        $('#btn_search').attr("type","submit");

    });
    $("#btn_export").click(function(){
        
        $("#tsReportForm").attr("action", "overtimeReport/export");

        $('#btn_export').attr("type","submit");

    });


    $record = {{@$data['response']->total()}};

    if ($record <=0) {

        $('#btn_export').css('background-color', 'gray');

        $('#btn_export').bind('click', function(e){

            e.preventDefault();
        })
    }

});
</script>
@endsection
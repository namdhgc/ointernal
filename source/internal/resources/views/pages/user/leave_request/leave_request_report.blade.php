@extends('layouts.user.master')

@section('title')
    {{Lang::get('user/leave_request_report.leave_request')}}
@endsection

@section('script')

@endsection

@section('content')



<div class="main-left">
    <center><label><legend class="titleStyle">{{Lang::get('user/leave_request_report.leave_request_report')}}</legend></label></center>
    <form id="tsReportForm" class="search_form" action="" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>

        <div class="portlet box yellow">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>{{ Lang::get('user/leave_request_report.btnSearch') }}
                </div>

            </div>

            <div class="portlet-body">
                <div id="date_notification" style="color:#f44242"></div>
                <div class="floating-box">
                    <label class="h4">{{Lang::get('user/leave_request_report.start_date')}}</label>
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
                    <label class="h4">{{Lang::get('user/leave_request_report.end_date')}}</label>
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
                <button type="button" class="btn btn-warning btnStyle btn_reset">{{Lang::get('user/leave_request_report.btnReset')}}</button>
                <button type="button" id="btn_search" class="btn btn-primary btnStyle">{{Lang::get('user/leave_request_report.btnSearch')}}</button>
                <button type="button" id="btn_export" class="btn btn-success btnStyle"><a href="{{ URL::route('user-leaveRequestReport/export') }}?&startDate    ={{ $data['extra']['search_startDate'] }}
														&endDate 	  ={{ $data['extra']['search_endDate'] }}">			
														</a>{{Lang::get('user/leave_request_report.btnExport')}}</button>
            </div>
        </div>

    </form>
</div>
    @if(@$data['response']->total() > 0)
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-cogs"></i>{{ Lang::get('user/leave_request_report.result') }}
            </div>

        </div>

        <div class="portlet-body">
            <div class="table-responsive">
                <table class="table table-bordered response">
                <thead>
                    <tr align="center">
                        <th>{{Lang::get('user/leave_request_report.em_id')}}</th>
                        <th>{{Lang::get('user/leave_request_report.start_date')}}</th>
                        <th>{{Lang::get('user/leave_request_report.end_date')}}</th>
                        <th>{{Lang::get('user/leave_request_report.types')}}</th>
                        <th>{{Lang::get('user/leave_request_report.approver')}}</th>
                        <th>{{Lang::get('user/leave_request_report.approved_date')}}</th>
                        <th>{{Lang::get('user/leave_request_report.status')}}</th>
                        <th>{{Lang::get('user/leave_request_report.note')}}</th>
                        <th>{{Lang::get('user/leave_request_report.action')}}</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    // var_dump(Auth::user());
                    // exit;
                ?>
                @foreach(@$data['response'] as $value)
                    <tr>
                    	<td>{{@$value->employee_id }}</td>
						<td>{{@$value->startDate . ' ' . $value->startTime }}</td>
						<td>{{@$value->endDate   . ' ' . $value->endTime }}</td>
						<td>{{@$value->types}}</td>
						<td>{{@$value->approverId}}</td>
                        <td>{{@$value->approvedDate}}</td>
						<td>
                            <?php
                                echo ($value->isApproved == 1) ? Lang::get('user/leave_request_report.accepted') : Lang::get('user/leave_request_report.pending')
                            ?>
                        </td>
                        <td>{{@$value->note }}</td>
                        <td>
                            <?php if(isset($value->isApproved) && $value->isApproved == 0): ?>
                                <!-- <a href="" target="_self">{{ Lang::get('user/leave_request_report.edit') }}</a> -->
                                <a href="{{ URL::Route('user-user_leave_request_detail') }}?id={{ $value->holiday_id }}&empCode={{ Auth::user()->employeeCode }}" target="_self">{{ Lang::get('admin/leave_request.edit') }}</a>
                            <?php endif;?>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                </table>
                {{@$data['response']->appends(
                	array('startDate'=>Input::get('startDate'),
                		  'endDate'  =>Input::get('endDate')))
                ->links()}}
    @elseif(@$data['response']->total() <= 0)
        <h3 class="notification">{{ Lang::get('user/leave_request_report.no_record') }}</h3>
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

        $("#tsReportForm").attr("action", "leaveRequestReport");

        $('#btn_search').attr("type","submit");

    });
	$("#btn_export").click(function(){
		
        $("#tsReportForm").attr("action", "leaveRequestReport/export");

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
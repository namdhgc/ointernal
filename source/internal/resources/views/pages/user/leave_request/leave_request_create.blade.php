@extends('layouts.user.master')

@section('title')
    {{Lang::get('user/leave_request.leave_request_log')}}
@endsection

@section('content')

<form class="form-horizontal submit_form" id="form_sample_2" method="post" action="{{URL::Route('user-add_leave_request')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="employeeId" value="{{Auth::user()->id}}">
    <center><label><legend class="titleStyle">{{Lang::get('user/leave_request.leave_request_log')}}</legend></label></center>

    <div id="overtime_content" >
        <div class="form-group row" >
            @if (Session::has('success'))
                <div id="msgSuccess" class="alert alert-success input-large" style="text-align: center; ;margin: 0px auto;font-weight: 600;font-size: 120%;">{{ Session::get('success') }}
                </div>
            @endif
        </div>

        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>{{ Lang::get('user/leave_request.detail') }}
                </div>
            </div>

            <div class="portlet-body">
                <div class="form-group row" >
                    <label class="col-form-label col-sm-2 col-sm-offset-2" >{{Lang::get('user/leave_request.start_date')}}</label>
                    <div class="col-sm-6">
                        <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                            <input type="text" class="form-control" id="inputStartDate"  name="startDate" value="" required="">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 col-sm-offset-2" ></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" id="inputStartTime" name="startTime" class="form-control timepicker timepicker-24" value="" required="">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-clock-o"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row" >
                    <label class="col-form-label col-sm-2 col-sm-offset-2" >{{Lang::get('user/leave_request.end_date')}}</label>
                    <div class="col-sm-6">
                        <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                            <input type="text" class="form-control" id="inputEndDate"  name="endDate" value="" required="">
                            <span class="input-group-btn">
                                <button class="btn default" type="button">
                                    <i class="fa fa-calendar"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 col-sm-offset-2" ></label>
                    <div class="col-sm-6">
                        <div class="input-group">
                            <input type="text" id="inputEndTime" name="endTime" class="form-control timepicker timepicker-24" value="" required="">
                                <span class="input-group-btn">
                                    <button class="btn default" type="button">
                                        <i class="fa fa-clock-o"></i>
                                    </button>
                                </span>
                        </div>
                        <div id="notification" class="input-large" style="color:#f44242">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/leave_request.approver')}}</label>
                    <div class="col-sm-6">
                        <select class="form-control" id="selectApprover" name="approverId" required="">
                            <option value="1">{{Lang::get('user/leave_request.approverId_1')}}</option>
                            <option value="2">{{Lang::get('user/leave_request.approverId_2')}}</option>
                            <option value="3">{{Lang::get('user/leave_request.approverId_3')}}</option>
                        </select>
                    </div>
                    <div class="form-control-focus"> </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/leave_request.type')}}</label>
                    <div class="col-sm-6">
                        <?php
                            $arr_leave_types = Config::get('leave_types');
                            $count_arr_leave_types = count($arr_leave_types);
                        ?>
                        <select class="form-control" id="selectType" name="typeId" required="">
                            @for ($i = 0; $i< $count_arr_leave_types; $i++)
                                <option value="{{ $i }}">
                                    <span>{{ $arr_leave_types[$i] }}</span>
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/leave_request.note')}}</label>
                    <div class="col-sm-6">
                        <textarea class="form-control id="txaNote" rows="5" name="note" required=""></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-5">
                        <button id="btnSubmit" type="submit" class="btn btn-primary col-sm-2 btnStyle">{{Lang::get('user/leave_request.btnSubmit')}}</button>
                        <button id="btnReset" type="button" class="btn btn-success btnStyle btn_reset">{{Lang::get('user/leave_request.btnReset')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('js')
<script type="text/javascript">
  //check startTime < endTime
  // $( document ).ready(function() {

  // $('#btnSubmit').click(function(event) {

  //     $startTime = $('#inputStartTime').val();
  //     $endTime = $('#inputEndTime').val();
  //     $checkNullDate = $('#inputDate').val();

  //     if ( $checkNullDate!="" && $startTime >= $endTime) {
  //       $('#btnSubmit').attr('type', 'button');
  //       $('#msgCheckEndTime').attr('style', 'display:block');

  //     }else{

  //       $('#btnSubmit').attr('type', 'submit');
  //       $('#msgCheckEndTime').attr('style', 'display:none');
  //     }
  //   });
  // });

$(document).ready(function() {

    $('#btnSubmit').click(function() {

        var startDate   = document.getElementById("inputStartDate").value;
        var endDate     = document.getElementById("inputEndDate").value;

        var startTime   = document.getElementById("inputStartTime").value;
        var endTime     = document.getElementById("inputEndTime").value;

        var start_time  = new Date(startDate + ' ' + startTime);
        start_time      = start_time.getTime();

        var end_time    = new Date(endDate + ' ' + endTime);
        end_time        = end_time.getTime();

        // var form = $(this).closest('form');

        if (start_time >= end_time) {

            $('#btnSubmit').attr("type","button");
            $('#notification').text("{{ Lang::get('user/leave_request.end_time_after_start_time') }}");

        }else{

            $('#btnSubmit').attr("type","submit");
            // form.submit();
        }
    });
});
</script>
{{-- <script src="{{ URL::asset('assets/pages/scripts/form-validation-md.js') }}"></script> --}}

<script src="{{ URL::asset('js/messages_vi.js') }}"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
@endsection()
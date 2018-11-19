@extends('layouts.user.master')

@section('title')
    {{Lang::get('user/overtime_log.overtime_log')}}
@endsection

@section('content')
<form class="form-horizontal submit_form" id="overtime_log" method="post" action="{{URL::Route('user-addOvertime')}}">
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="employeeId" value="{{Auth::user()->id}}">
  <center><label><legend class="titleStyle">{{Lang::get('user/overtime_log.overtime_log')}}</legend></label></center>

  <div id="overtime_content" >
    <div class="form-group row" >
      <div class="col-sm-8 col-sm-offset-4">
        @if (Session::has('success'))
          <label><div id="msgSuccess" class="alert alert-success">{{ Session::get('success') }}</div></label>
        @endif
      </div>
    </div>

    <div class="portlet box green">
      <div class="portlet-title">
          <div class="caption">
              <i class="fa fa-cogs"></i>{{ Lang::get('user/overtime_log.detail') }}
        </div>
      </div>

      <div class="portlet-body">
        <div class="form-group row" >
          <label class="col-form-label col-sm-2 col-sm-offset-2" >{{Lang::get('user/overtime_log.date')}}</label>
          <div class="col-sm-6">
            <div class="input-group date date-picker" data-date="" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
              <input type="text" class="form-control" id="inputDate"  name="date" value="" required="">
              <span class="input-group-btn">
                  <button class="btn default" type="button">
                      <i class="fa fa-calendar"></i>
                  </button>
              </span>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2 col-sm-offset-2" >{{Lang::get('user/overtime_log.startTime')}}</label>
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
        <div class="form-group row">
          <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/overtime_log.endTime')}}</label>
          <div class="col-sm-6">
              <div class="input-group">
                <input type="text" id="inputEndTime" name="endTime" class="form-control timepicker timepicker-24" value="" required="">
                <span class="input-group-btn">
                    <button class="btn default" type="button">
                        <i class="fa fa-clock-o"></i>
                    </button>
                </span>
              </div>
              <label id="msgCheckEndTime" class="msgValid" style="display: none">{{Lang::get('user/overtime_log.msgCheckEndTime')}}</label>
              <div class="help-block with-errors"></div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/overtime_log.approver')}}</label>
          <div class="col-sm-6">
            <?php
              $arr_approver = Config::get('approver');
              $count_arr_approver = count($arr_approver);
            ?>
            <select class="form-control" id="selectApprover" name="approverId" required="">
              @for ($i = 1; $i <= $count_arr_approver; $i++)
                <option value="{{ $i }}">
                  <span>{{ $arr_approver[$i] }}</span>
                </option>
              @endfor
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/overtime_log.overtime_type')}}</label>
          <div class="col-sm-6">
            <?php
              $arr_overtime_types = Config::get('overtime_types');
              $count_arr_overtime_types = count($arr_overtime_types);
            ?>
            <select class="form-control" id="selectType" name="typeId" required="">
            @for ($i = 0; $i < $count_arr_overtime_types; $i++)
              <option value="{{ $i }}">
                <span>{{ $arr_overtime_types[$i] }}</span>
              </option>
            @endfor
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-form-label col-sm-2 col-sm-offset-2"  >{{Lang::get('user/overtime_log.note')}}</label>
          <div class="col-sm-6">
            <textarea class="form-control" required="" id="txaNote" rows="5" name="note"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-4 col-sm-5">
            <button id="btnSubmit" type="submit" class="btn btn-primary col-sm-2 btnStyle">{{Lang::get('user/overtime_log.btnSubmit')}}</button>
            <button id="btnReset" type="button" class="btn btn-success btnStyle btn_reset">{{Lang::get('user/overtime_log.btnReset')}}</button>
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
  $( document ).ready(function() {

  // $('#btnSubmit').click(function(event) {

    //   $startTime = $('#inputStartTime').val();
    //   $endTime = $('#inputEndTime').val();
    //   $checkNullDate = $('#inputDate').val();

    //   if ( $checkNullDate!="" && $startTime >= $endTime) {
    //     $('#btnSubmit').attr('type', 'button');
    //     $('#msgCheckEndTime').attr('style', 'display:block');

    //   }else{

    //     $('#btnSubmit').attr('type', 'submit');
    //     $('#msgCheckEndTime').attr('style', 'display:none');
    //   }
    // });
  });
</script>
@endsection()
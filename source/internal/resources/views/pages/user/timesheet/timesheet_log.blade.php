@extends('layouts.user.master')

@section('title')
    {{Lang::get('user/timesheet_log.log_time_sheet')}}
@endsection

@section('script')

{{-- <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Hour');
        @if(@$data_chart['chart']!=null)
        @foreach(@$data_chart['chart'] as $dt)
        var d = new Date();
        data.addRows([
          ['{{$dt->date}}', {{$dt->totalTimePerDay}}]
        ]);

        @endforeach
        var options = {'title':'{{Lang::get('user/timesheet_log.chart_title')}}',
                       'width':1000,
                       'height':300};
        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      @endif


      //date time live
        function display_c(){
            var refresh=1000; // Refresh rate in milli seconds
            mytime=setTimeout('display_ct()',refresh)
            }

            function display_ct() {
            var strcount
            var x = new Date()
            document.getElementById('ct').innerHTML = x;
            tt=display_c();
        }
       </script> --}}

@endsection

@section('content')
    <center><label><legend class="titleStyle">{{Lang::get('user/timesheet_log.log_time_sheet')}}</legend></label></center>

    @if (Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <form id="timesheetForm" class="submit_form" action="timesheet/create" method="POST">
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
            @if($data_new!=null)
            <input type="hidden" name="id" value="{{$data_new->id}}">
            @endif
    {{--         <input type="hidden" name="date" value="{{date('Y-m-d')}}">
            <input type="hidden" name="startDate" value="{{date('Y-m-d H:i')}}">
            <input type="hidden" name="endDate" value="{{date('Y-m-d H:i:s')}}"> --}}
            <div class="form-group" id="form-group">

                <label id="noteLabel" for="note" class="h4 ">{{Lang::get('user/timesheet_log.note')}}</label>

                <textarea id="note" class="form-control" name="note" rows="5" placeholder="{{Lang::get('user/timesheet_log.note_holder')}}" ></textarea>

            </div>

        <button type="submit" id="btn_add" class="btn btn-primary">{{Lang::get('user/timesheet_log.btnStart')}}</button>
        <button type="submit" id="btn_end" class="btn btn-success">{{Lang::get('user/timesheet_log.btnEnd')}}</button>
    </form>
    <br/>


{{-- <div id="chart_div"></div>     --}}

@if(@$data['response']->total() > 0)

<div class="portlet box green">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa fa-cogs"></i>{{ Lang::get('user/timesheet_log.detail') }}
        </div>

    </div>

    <div class="portlet-body">
        <div class="table-responsive">
            <h3>{{Lang::get('user/timesheet_log.recent_day')}}</h3>
            <table class="table table-bordered">
            <thead>
                <tr align="center">
                    <th>{{Lang::get('user/timesheet_log.em_id')}}</th>
                    <th>{{Lang::get('user/timesheet_log.date')}}</th>
                    <th>{{Lang::get('user/timesheet_log.start_time')}}</th>
                    <th>{{Lang::get('user/timesheet_log.end_time')}}</th>
                    <th>{{Lang::get('user/timesheet_log.time_per_day')}}</th>
                    <th>{{Lang::get('user/timesheet_log.time_per_month')}}</th>
                    <th>{{Lang::get('user/timesheet_log.note')}}</th>
                </tr>
            </thead>

            <tbody>
            @foreach(@$data['response'] as $dt)
                <tr>
                    <td>{{$dt->employeeId}}</td>
                    <td>{{$dt->date}}</td>
                    <td>{{$dt->startDate}}</td>
                    <td>{{$dt->endDate}}</td>
                    <td>{{$dt->timePerDayFormat}}</td>
                    <td>{{$dt->timePerMonthFormat}}</td>
                    <td>{{$dt->note}}</td>
                </tr>
            @endforeach
            </tbody>

            </table>
        </div>
    </div>
</div>


{{@$data['response']->links()}}

@elseif(@$data['response']->total() <= 0)
<h3 class="notification">{{ Lang::get('user/overtime_report.messageTimesheet') }}</h3>
@endif

@endsection

@section('js')
<script type="text/javascript">


    //check ative button

    {{-- //if ({{$active}}==0) { --}}
        {{-- //alert({{$active}}); --}}
        //$("#btn_add").attr("disabled","");
        //$("#btn_edit").attr("disabled","");
    {{-- //}else if ({{$active}}==1) { --}}
    //    $("#btn_add").attr("disabled","");
    //}

$(document).ready(function(){
        //Action and delete for check in button
        $('#btn_add').click(function(){
            $('#timesheetForm').attr("action", "timesheet_log/check-in");
        });

        @if($statusCheckIn == true)
            $('#btn_add').remove();

        @endif

        //Action and delete for check out button
        $('#btn_end').click(function(){
            $('#timesheetForm').attr("action", "timesheet_log/check-out");
        });

        @if ($statusCheckOut == false)
            $('#btn_end').remove();
            $('#form-group').remove();
        @endif

        //Validate neu nguoi dung nghich F12 va doi attr cua input btn
});
</script>

@endsection
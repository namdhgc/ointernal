@extends('layouts.user.master')

@section('title')
    {{ Lang::get('user/summary.summary') }}
@endsection

@section('content')
<div class="page-content-wrapper">
            <center>
                <label>
                    <legend class="titleStyle">
                        {{ Lang::get('user/summary.summary_management_title') }}
                    </legend>
                </label>
            </center>

            <?php
                $global_employeeCode = Auth::user()->employeeCode;
            ?>
            <form action="{{ URL::Route('user-summary_search') }}" class="search_form" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="global_employeeCode" value="{{ @$global_employeeCode }}">

                <div class="portlet box yellow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>{{ Lang::get('user/summary.btn_search') }}
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
                        <br/>
                        <input type="button" class="btn btn-warning btn_reset" value="{{ Lang::get('user/summary.btn_reset') }}">
                        <input type="button" class="btn btn-primary" id="btn_search" name="action" value="{{ Lang::get('user/summary.btn_search') }}">
                        <a href="{{ URL::route('adm-export_summary') }}?&startDate={{ $data['extra']['search_startDate'] }}
                            &endDate={{ $data['extra']['search_endDate'] }}" class="btn btn-success" id="btn_export">
                            {{ Lang::get('user/summary.btn_export') }}
                        </a>
                    </div>
                </div>


            </form>

            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs"></i>{{ Lang::get('user/summary.result') }}
                    </div>
                </div>

                <div class="portlet-body">
                    <div class="table-responsive">
                        @php
                            $count          = $data['response']->total();
                            $endDate        = isset($data['extra']['search_endDate']) ? $data['extra']['search_endDate'] : '';
                            $startDate      = isset($data['extra']['search_startDate']) ? $data['extra']['search_startDate'] : '';
                        @endphp
                        @if (isset($data['response']))

                            <input type="hidden" id="count" value="{{ $count }}">

                            @if ($count != 0)
                                <table class="table table-striped table-bordered">
                                    <tr class="info">
                                        <th>{{ Lang::get('user/summary.employee_code') }}</th>
                                        <th>{{ Lang::get('user/summary.employee_name') }}</th>
                                        <th>{{ Lang::get('user/summary.total_accepted_overtime') }}</th>
                                        <th>{{ Lang::get('user/summary.total_workingtime') }}</th>
                                        <th>{{ Lang::get('user/summary.approved_holiday') }}</th>
                                        <th>{{ Lang::get('user/summary.not_approve_holiday') }}</th>
                                    </tr>

                                    @foreach ($data['response'] as $key => $value)
                                    <tr>
                                        <td>{{ $value->employeeCode }}</td>
                                        <td>{{ $value->firstname . ' ' . $value->lastname }}</td>
                                        <td>{{ $value->total_accepted_overtime }}</td>
                                        <td>{{ $value->total_workingtime }}</td>
                                        <td>{{ $value->approved_holiday}}</td>
                                        <td>{{ $value->not_approve_holiday }}</td>
                                    </tr>
                                    @endforeach

                                </table>
                            @else
                                <h3 class="notification">{{ Lang::get('user/summary.no_record') }}</h3>
                            @endif
                        @endif

                        {{ $data['response']->appends([
                            'startDate'     => Input::get('startDate'),
                            'endDate'       => Input::get('endDate'),
                        ])->links() }}
                    </div>
                </div>
            </div>

</div>
@endsection

@section('js')

@endsection
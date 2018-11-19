@extends('layouts.user.master')

@section('title')
	Leave Request
@endsection

@section('css')
	<link href="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
	<script src="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="container">
			<div class="row">
			    <div class="col-md-5">
			        <!-- BEGIN VALIDATION STATES-->
			        <div class="portlet light portlet-fit portlet-form bordered">
			            <div class="portlet-title">
			                <div class="caption">
			                    <i class=" icon-layers font-red"></i>
			                    <span class="caption-subject font-red sbold uppercase">{{ Lang::get('user/upload_file.title') }}</span>
			                    @if (session('msg_code'))
			                    	<p class="caption-subject font-red sbold uppercase">{{ Config::get('error_message.' . session('msg_code')) }}</p>
			                    @endif
			                </div>
			                <div class="actions">
			                </div>
			            </div>
			            <div class="portlet-body form">
			            	<form action="{{ URL::Route('user-upload') }}" class="form-horizontal form-bordered" enctype="multipart/form-data" method="POST">
			            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
				            	<div class="form-body">
				            		<div class="form-group last">
				                        <label class="control-label col-md-3">{{ Lang::get('user/upload_file.title') }}</label>
				                        <div class="col-md-9">
				                            <div class="fileinput fileinput-new" data-provides="fileinput">
				                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
				                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
				                              	</div>
				                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
				                                <div>
				                                	<input type="submit" class="btn btn-success fileinput-exists">
				                                    <span class="btn default btn-file">
				                                        <span class="fileinput-new">
				                                        	<input type="file" name="upload_file">
				                                        </span>
				                                        <span class="fileinput-exists">{{ Lang::get('user/upload_file.change') }}</span>
				                                  	</span>
				                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">{{ Lang::get('user/upload_file.remove') }}</a>

				                                </div>
				                            </div>
				                        </div>
				                    </div>
				            	</div>
				            </form>
			            </div>
			        </div>
			    </div>
			    <div class="col-md-7">
			        <!-- BEGIN EXAMPLE TABLE PORTLET-->
			        <div class="portlet light bordered">
			            <div class="portlet-title">
			                <div class="caption ">
			                    <i class="icon-settings font-green"></i>
			                    <span class="caption-subject bold uppercase font-green">{{ Lang::get('user/upload_file.documents') }}</span>
			                </div>
			                <div class="actions">

			                    <div class="btn-group">
			                    </div>
			                </div>
			            </div>
			            <div class="portlet-body">
			                <div class="table-toolbar">
			                    <div class="row">
			                    </div>
			                    <div class="form-group">
			                        <div class="portlet box green">
		                                <div class="portlet-title">
		                                    <div class="caption">
		                                        <i class="fa fa-cogs"></i>{{ Lang::get('user/upload_file.documents') }}</div>
		                                    <div class="tools">
		                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
		                                    </div>
		                                </div>
		                                <div class="portlet-body flip-scroll">
		                                    <table class="table table-bordered table-striped table-condensed flip-content">
		                                        <thead class="flip-content">
		                                            <tr>
		                                                <th width="20%">{{ Lang::get('user/upload_file.id') }}</th>
		                                                <th>{{ Lang::get('user/upload_file.name') }}</th>
		                                                <th>{{ Lang::get('user/upload_file.type') }}</th>
		                                            </tr>
		                                        </thead>
		                                        <tbody>
		                                        @if (isset($data) && $data['response']->total() != 0)
		                                        	@foreach ($data['response'] as $key => $item)
		                                            <tr data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-type="{{ $item->type }}">
		                                                <td> {{ $item->id }} </td>
		                                                <td> 
		                                                	<a href="{{ URL::asset('upload_file/' . $item->temp_name . '.' . $item->extension) }}" download="{{ $item->name }}">{{ $item->name }}</a>
		                                                </td>
		                                                <td> {{ $item->type }} </td>
		                                            </tr>
		                                            @endforeach
		                                      	@endif
		                                        </tbody>
		                                    </table>
		                                    {{ $data['response']->appends([])->links() }}
		                                </div>
		                            </div>
			                    </div>
			                </div>
			                
			            </div>
			        </div>
			        <!-- END EXAMPLE TABLE PORTLET-->
			    </div>
			</div>
		</div>
	</div>
</div>
@endsection
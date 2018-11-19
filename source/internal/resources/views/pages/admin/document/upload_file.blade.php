@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/upload_file.title') }}
@endsection

@section('css')
	<link href="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('js')
<script src="{{ URL::asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>

<script>
	$(document).ready(function(){

        $(".btn_delete").on("click", function() {

            var id      = $(this).closest('[data-id]').data("id");
            var name    = $(this).closest('[data-name]').data("name");

            $("#id").attr("value", id);
            $("#modal_delete_id").text(id);
            $("#modal_delete_name").text(name);

        });

        $(".btn_modal_delete").on("click", function() {

            $(".delete_form").submit();
        });
    });
</script>
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<div class="row">
			    <div class="col-md-5">
			        <!-- BEGIN VALIDATION STATES-->
			        <div class="portlet light portlet-fit portlet-form bordered">
			            <div class="portlet-title">
			                <div class="caption">
			                    <i class=" icon-layers font-red"></i>
			                    <span class="caption-subject font-red sbold uppercase">{{ Lang::get('admin/upload_file.title') }}</span>
			                    @if (session('msg_code'))
			                    	<p class="caption-subject font-red sbold uppercase">{{ Config::get('error_message.' . session('msg_code')) }}</p>
			                    @endif
			                </div>
			                <div class="actions">
			                </div>
			            </div>
			            <div class="portlet-body form">
			            	<form action="{{ URL::Route('adm-upload') }}" class="form-horizontal form-bordered" enctype="multipart/form-data" method="POST">
			            		<input type="hidden" name="_token" value="{{ csrf_token() }}">
				            	<div class="form-body">
				            		<div class="form-group last">
				                        <label class="control-label col-md-3">{{ Lang::get('admin/upload_file.title') }}</label>
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
				                                        <span class="fileinput-exists">{{ Lang::get('admin/upload_file.change') }}</span>
				                                  	</span>
				                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">{{ Lang::get('admin/upload_file.remove') }}</a>

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
			                    <span class="caption-subject bold uppercase font-green">{{ Lang::get('admin/upload_file.documents') }}</span>
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
		                                        <i class="fa fa-cogs"></i>{{ Lang::get('admin/upload_file.documents') }}</div>
		                                    <div class="tools">
		                                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
		                                    </div>
		                                </div>
		                                <div class="portlet-body flip-scroll">
		                                    <table class="table table-bordered table-striped table-condensed flip-content">
		                                        <thead class="flip-content">
		                                            <tr>
		                                                <th width="20%">{{ Lang::get('admin/upload_file.id') }}</th>
		                                                <th>{{ Lang::get('admin/upload_file.name') }}</th>
		                                                <th>{{ Lang::get('admin/upload_file.type') }}</th>
		                                                <th>{{ Lang::get('admin/upload_file.action') }}</th>
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
		                                                <td> <input type="button" class="btn btn-xs btn-danger btn_delete" id="" value="{{ Lang::get('admin/upload_file.delete') }}" data-toggle="modal" data-target="#modalDelete"> </td>
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

			            <!-- Modal delete-->
	                    @if(isset($data) && $data['response']->total() != 0)
	                    <div class="modal fade" id="modalDelete" role="dialog">
	                        <div class="modal-dialog">
	                            <!-- Modal content-->
	                            <div class="modal-content">
	                                <div class="modal-header">
	                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
	                                    <h4 class="modal-title">{{ Lang::get('admin/upload_file.delete_file') }}</h4>
	                                </div>
	                                <div class="modal-body">
	                                    <form action="{{ URL::Route('adm-post-delete-file') }}" method="POST" class="delete_form form-edit">
	                                        <table class="table table-striped" id="tblGrid">
	                                            <thead id="tblHead">
	                                                <tr>
	                                                    <th>{{ Lang::get('admin/upload_file.id') }}</th>
	                                                    <th>{{ Lang::get('admin/upload_file.name') }}</th>
	                                                    <th>{{ Lang::get('admin/upload_file.type') }}</th>
	                                                </tr>
	                                            </thead>
	                                            <tbody>
	                                                <tr>
	                                                    <td>
	                                                        <input type="hidden" name="id" id="id" value="">
	                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                                        <span id="modal_delete_id"></span>
	                                                    </td>
	                                                    <td>
	                                                        <span id="modal_delete_name"></span>
	                                                    </td>
	                                                    <td>
	                                                        <span id="modal_delete_type"></span>
	                                                    </td>
	                                                </tr>
	                                            </tbody>
	                                        </table>
	                                    </form>
	                                </div>
	                                <div class="modal-footer">
	                                    <button type="submit" class="btn btn-danger btn_modal_delete" data-dismiss="modal">{{ Lang::get('admin/upload_file.delete') }}</button>
	                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('admin/upload_file.cancel') }}</button>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                    @endif
	                    <!-- End modal delete -->

			        </div>
			        <!-- END EXAMPLE TABLE PORTLET-->
			    </div>
			</div>

		</div>
	</div>
</div>

@endsection

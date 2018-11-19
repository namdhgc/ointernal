@extends('layouts.admin.master')

@section('title')
	{{ Lang::get('admin/news.title') }}
@endsection

@section('css')
<link href="{{ URL::asset('css/indication/style.css') }}" rel="stylesheet" type="text/css" media="screen" />
@endsection

@section('js')
<script src="{{ URL::asset('assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>

<script>
	$(document).ready(function(){

        $(".btn_edit").on("click", function() {

            var id      	= $(this).closest('[data-id]').data("id");
            var title    	= $(this).closest('[data-title]').data("title");
            var content    	= $(this).closest('[data-content]').data("content");

            $("#id").attr("value", id);
            $("#modal_edit_id").text(id);
            // $("#modal_edit_title").val(title);
            // $("#modal_edit_content").text(content);
            CKEDITOR.instances['modal_edit_title'].setData(title);
            CKEDITOR.instances['modal_edit_content'].setData(content);

        });

        $(".btn_modal_edit").on("click", function() {

            $(".edit_form").submit();
        });
    });
</script>
@endsection


@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<div id="page-bgbtm">
				<div id="content" class="col-md-12">
					@if(isset($data))
						@foreach($data['response'] as $key => $item)
						<div class="post" data-id="{{ $item->id }}" data-title="{{ $item->title }}" data-content="{{ $item->content }}">
							<h2 class="title"><a href="#"><?php echo $item->title; ?></a></h2>
							<p class="meta">
								<span class="date">
									<span>{{ Lang::get('admin/news.posted_date') }}: </span>
									<?php
										echo date("Y-m-d H:i", $item->created_date);
									?>
								</span>

								@if (isset($item->updated_date) && $item->updated_date != null)
								<span class="date">
									<span>{{ Lang::get('admin/news.edited_date') }}: </span>
									<?php
										echo date("Y-m-d H:i", $item->updated_date);
									?>
								</span>
								@endif
								<span class="posted">{{ Lang::get('admin/news.posted_by') }}: <a href="#">{{ $item->firstname . ' ' . $item->lastname }}</a></span>
							</p>
							<div style="clear: both;">&nbsp;</div>
							<div class="entry">
								<?php
									echo $item->content;
								?>
								<p class="links">
									<a href="#">{{ Lang::get('admin/news.read_more') }}</a>
									&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#">{{ Lang::get('admin/news.comments') }} </a>
									&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
									<a href="#" class="btn_edit" data-toggle="modal" data-target="#modalEdit">{{ Lang::get('admin/news.edit') }} </a>
								</p>
							</div>
						</div>
						<hr>
						@endforeach
					@endif
				<div style="clear: both;">&nbsp;</div>
				<!-- Modal edit-->
                    @if(isset($data) && $data['response']->total() != 0)
                    <div class="modal fade" id="modalEdit" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><b>{{ Lang::get('admin/news.edit_document') }}</b></h4>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ URL::Route('adm-post-edit-news') }}" method="POST" class="edit_form">
                                        <table class="table table-striped" id="tblGrid">
                                            <thead id="tblHead">
                                                <tr>
                                                    <th>{{ Lang::get('admin/news.id') }}</th>
                                                    <th>{{ Lang::get('admin/news.title') }}</th>
                                                    <th>{{ Lang::get('admin/news.content') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="id" id="id" value="">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <span id="modal_edit_id"></span>
                                                    </td>
                                                    <td>
                                                    	<div class="col-md-9">
				                                            <textarea id="modal_edit_title" class="ckeditor form-control" name="title" rows="6"></textarea>
				                                        </div>
                                                    </td>
                                                    <td>
                                                    	<div class="col-md-9">
				                                            <textarea id="modal_edit_content" class="ckeditor form-control" name="content" rows="6"></textarea>
				                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger btn_modal_edit" data-dismiss="modal">{{ Lang::get('admin/news.edit') }}</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ Lang::get('admin/news.cancel') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- End modal edit -->
				</div>
				<!-- end #content -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
@endsection
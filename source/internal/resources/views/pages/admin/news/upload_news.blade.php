@extends('layouts.admin.master')

@section('title')
    {{ Lang::get('admin/news.upload_news_title') }}
@endsection

@section('css')
@endsection

@section('js')
<script src="{{ URL::asset('assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN EXTRAS PORTLET-->
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-gift"></i>{{ Lang::get('admin/news.upload_news_title') }}</div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <!-- BEGIN FORM-->
                            <form action="{{ URL::Route('adm-post-upload-news') }}" class="form-horizontal form-bordered" method="POST">
                                {{ csrf_field() }}
                                <div class="form-body">
                                    <div class="form-group last">
                                        <label class="control-label col-md-2">{{ Lang::get('admin/news.title') }}</label>
                                        <div class="col-md-9">
                                            <!-- <textarea class="ckeditor form-control" name="title" rows="6"></textarea> -->
                                            <input type="text" class="form-control" name="title">
                                        </div>
                                    </div>
                                    <div class="form-group last">
                                        <label class="control-label col-md-2">{{ Lang::get('admin/news.content') }}</label>
                                        <div class="col-md-9">
                                            <textarea class="ckeditor form-control" name="content" rows="6"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-2 col-md-9">
                                            <button type="submit" class="btn green" name="submit">
                                                <i class="fa fa-check"></i>{{ Lang::get('admin/news.submit') }}
                                            </button>
                                            <a href="javascript:;" class="btn btn-outline grey-salsa">{{ Lang::get('admin/news.cancel') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END EXTRAS PORTLET-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
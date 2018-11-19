@extends('layouts/user/master')

@section('title')
	{{ Lang::get('menu.notification') }}
@endsection

@section('css')
<style>
    /*.success {
        color: green;
    }

    .error {
        color: red;
    }*/
</style>
@endsection

@section('js')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">

            <div class="portlet-title">
                <div class="caption font-red-sunglo">
                    <i class="icon-settings font-red-sunglo"></i>
                    <span class="caption-subject bold uppercase"> Thông báo</span>
                </div>
                <div class="actions">
                    <div class="btn-group">
                    </div>
                </div>
            </div>
            <div class="portlet-body form">

                @if(Session::get('message')!='' && Session::get('message')!=null)
                <div class="alert {{ (Session::get('message')['meta']['code'] == 200) ? 'alert-success' : 'alert-danger' }}">
                    <h4> {{ Session::get('message')['meta']['msg'][0] }} </h4>
                </div>
                @endif
                
            </div>
        </div>
    </div>

</div>
@endsection
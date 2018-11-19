@extends('layouts.user.master')

@section('title')
	Tin tức
@endsection

@section('css')
<link href="{{ URL::asset('css/indication/style.css') }}" rel="stylesheet" type="text/css" media="screen" />
@endsection

@section('content')
<div class="page-content-wrapper">
	<div class="page-content">
		<div class="page-head">
			<div id="page-bgbtm">
				<div id="content" class="col-md-12">
					@if(isset($data))
						@foreach($data['response'] as $key => $item)
						<div class="post">
							<h2 class="title"><a href="#"><?php echo $item->title; ?></a></h2>
							<p class="meta">
								<span class="date">
									<span>{{ Lang::get('user/news.posted_date') }}: </span>
									<?php
										echo date("Y-m-d H:i", $item->created_date);
									?>
								</span>

								@if (isset($item->updated_date) && $item->updated_date != null)
								<span class="date">
									<span>{{ Lang::get('user/news.edited_date') }}: </span>
									<?php
										echo date("Y-m-d H:i", $item->updated_date);
									?>
								</span>
								@endif
								<span class="posted">{{ Lang::get('user/news.posted_by') }}: <a href="#">{{ $item->firstname . ' ' . $item->lastname }}</a></span>
							</p>
							<div style="clear: both;">&nbsp;</div>
							<div class="entry">
								<?php
									echo $item->content;
								?>
								<p class="links">
									<a href="#">{{ Lang::get('user/news.read_more') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;<a href="#">{{ Lang::get('user/news.comments') }} </a>
								</p>
							</div>
						</div>
						<hr>
						@endforeach
					@endif
				<div style="clear: both;">&nbsp;</div>
				</div>
				<!-- end #content -->
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
@endsection()
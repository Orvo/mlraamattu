@extends('layout.public')

@section('content')
	<div class="page-body">
		{!! $page->body !!}
	</div>
@endsection

@if(strlen(trim($page->sidebar_body)) > 0)
	@section('sidebar_content')
		<div class="page-sidebar-body">
			{!! $page->sidebar_body !!}
		</div>
	@endsection
@endif
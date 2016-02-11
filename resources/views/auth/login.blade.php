@extends('layout')

@section('content')
	
	<h1>Kirjaudu sisään</h1>

	{!! Form::open(['method' => 'POST', 'action' => 'AuthController@login', 'style' => 'width:75%;margin:2em auto 0 auto']) !!}

		{!! csrf_field() !!}
		
		@if($referer)
			<input type="hidden" name="ref" value="{{ $referer }}">
			<input type="hidden" name="route" value="{{ $route }}">
		@endif

		@if($errors->any())
			<div class="alert alert-danger alert-icon">
				<span class="glyphicon glyphicon-remove-sign"></span>
				<div>
					<b>Hupis!</b> Kirjautuminen epäonnistui.
					<hr>
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
				<div class="clearfix"></div>
			</div>
		@endif

		<div class="form-group @if($errors->first('email')) has-error @endif">
			{!! Form::text('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Sähköposti']) !!}
		</div>

		<div class="form-group @if($errors->first('password')) has-error @endif">
			{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'Salasana']) !!}
		</div>

		<div class="form-group row">
			<div class="col-xs-6">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('remember_me', null, null, ['id' => 'remember_me']) !!} Muista kirjautuminen
					</label>
				</div>
			</div>
			<div class="col-xs-6">
				<button type="submit" class="btn btn-primary btn-block">
					Kirjaudu sisään <span class="glyphicon glyphicon-log-in"></span>
				</button>
			</div>
		</div>
		
		<div class="form-group pull-right">
			<a href="/auth/reset">Unohtunut salasana?</a>
		</div>
	
	{!! Form::close() !!}

@endsection
@extends('layout')

@section('content')
	
	<h1>Kirjaudu sisään</h1>

	{!! Form::open(['method' => 'POST', 'action' => 'AuthController@login', 'style' => 'width:75%;margin:2em auto 0 auto']) !!}

		{!! csrf_field() !!}

		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<div class="form-group @if($errors->first('email')) has-error @endif">
			{!! Form::text('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Sähköposti']) !!}
			<small class="text-danger">{{ $errors->first('email') }}</small>
		</div>

		<div class="form-group @if($errors->first('password')) has-error @endif">
			{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'Salasana']) !!}
			<small class="text-danger">{{ $errors->first('password') }}</small>
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
	
	{!! Form::close() !!}

@endsection
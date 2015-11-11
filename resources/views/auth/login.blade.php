@extends('layout')

@section('content')
	
	<h1>Login</h1>

	{!! Form::open(['method' => 'POST', 'action' => 'AuthController@login', 'class' => 'form-horizontal', 'style' => 'width:75%;margin:0 auto']) !!}

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
			{!! Form::text('email', null, ['class' => 'form-control input-lg', 'placeholder' => 'Email']) !!}
			<small class="text-danger">{{ $errors->first('email') }}</small>
		</div>

		<div class="form-group @if($errors->first('password')) has-error @endif">
			{!! Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => 'Password']) !!}
			<small class="text-danger">{{ $errors->first('password') }}</small>
		</div>
		
		<div class="form-group">
			{!! Form::submit('Login', ['class' => 'btn btn-primary btn-lg btn-block']) !!}
		</div>
	
	{!! Form::close() !!}

@endsection
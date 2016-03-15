@extends('layout.main')

@section('title')
	Salasanan palautus
@endsection

@section('content')

	{!! Form::open(['method' => 'POST', 'action' => 'Auth\PasswordController@postEmail', 'class' => 'centered-form']) !!}

		{!! csrf_field() !!}
	
		<h1>Unohtunut salasana</h1>

		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		
		@if(@$status)
			<div class="alert alert-success">
				{{ @$status }}
			</div>
		@endif
		
		<div class="form-group">
			<p>
				Syötä sähköpostiosoitteesi allaolevaan kenttään niin lähetämme sinulle ohjeet salasanan uusimiseen.
			</p>
		</div>

		<div class="form-group @if($errors->first('email')) has-error @endif">
			<input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Sähköposti">
		</div>

		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">
				Lähetä
			</button>
		</div>
	
	{!! Form::close() !!}

@endsection
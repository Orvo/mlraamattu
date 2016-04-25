@extends('layout.public')

@section('title', 'Kirjaudu sisään')

@section('content')
	
	{!! Form::open(['method' => 'POST', 'action' => 'AuthController@login', 'class' => 'centered-form']) !!}
		
		@if($referer)
			<input type="hidden" name="ref" value="{{ $referer }}">
			<input type="hidden" name="route" value="{{ $route }}">
		@endif
		
		<h1>Kirjaudu sisään</h1>

		@if($errors->any())
			<div class="alert alert-danger alert-icon">
				<span class="glyphicon glyphicon-remove-sign"></span>
				<div>
					<b>Hupsis!</b> Kirjautuminen epäonnistui.
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
			<div class="col-md-6">
				<div class="checkbox">
					<label>
						{!! Form::checkbox('remember_me', null, null, ['id' => 'remember_me']) !!} Muista kirjautuminen
					</label>
				</div>
			</div>
			<div class="col-md-6">
				<button type="submit" class="btn btn-primary btn-block">
					Kirjaudu sisään <span class="glyphicon glyphicon-log-in"></span>
				</button>
			</div>
		</div>
		
		<div class="form-group pull-right mobile-full-width" style="padding-top:1em">
			<a href="/auth/reset">Unohtunut salasana?</a>
		</div>
	
	{!! Form::close() !!}
	
	<div class="clearfix"></div>
	
	<div class="centered-form">
		<hr>
		<div>
			<h4>Ei tunnusta? Ei hätää!</h4>
			<p>
				Voit rekisteröidä itsellesi tunnuksen samalla kun suoritat koetta. 
				Aloita kurssin suorittaminen <a href="/course">täällä</a>. Kokeen lopusta voit löytää rekisteröitymislomakkeen.
			</p>
		</div>
	</div>
	
@endsection
@extends('layout.main')

@section('title')
	Käyttäjätietojen muokkaus
@endsection

@section('content')
	
	<h1>Käyttäjätietojen muokkaus</h1>

	{!! Form::open(['method' => 'POST', 'action' => 'AuthController@save', 'class' => 'form-horizontal']) !!}

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
		
		@if(@$success)
			<div class="alert alert-success">
				Tietosi on päivitetty.
			</div>
		@endif
		
		<fieldset>
			<legend>Perustiedot</legend>
			<div class="form-group">
				<label for="user-name" class="control-label col-xs-3">
					Käyttäjän nimi
				</label>
				<div class="col-xs-9">
					{!! Form::text('name', $user['name'], ['id' => 'user-name', 'class' => 'form-control', 'placeholder' => 'Nimi']) !!}
				</div>
			</div>
			<div class="form-group">
				<label for="user-email" class="control-label col-xs-3">
					Käyttäjän sähköposti
				</label>
				<div class="col-xs-9">
					{!! Form::text('email', $user['email'], ['id' => 'user-email', 'class' => 'form-control', 'placeholder' => 'Sähköposti']) !!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend>Salasana</legend>
			<div class="form-group">
				<p class="col-xs-offset-3">
					Jos tarpeen, voit vaihtaa tunnuksen salasanan syöttämällä uuden salasanan alle. Jätä kentät tyhjiksi jos et halua vaihtaa salasanaa.
				</p>
			</div>
			@if(Auth::user()->change_password)
				<div class="form-group">
					<div class="col-xs-offset-3 alert alert-danger alert-icon alert-icon-small login-note">
						<i class="fa fa-exclamation"></i>
						<div>
							<p>
								Ylläpito on tehnyt sinulle salasananvaihdon. Sinun tulisi vaihtaa salasanasi.
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			@endif
			<div class="form-group">
				<label for="user-current-password" class="control-label col-xs-3">
					Nykyinen salasana
				</label>
				<div class="col-xs-9">
					{!! Form::password('current_password', ['id' => 'user-current-password', 'class' => 'form-control', 'placeholder' => 'Nykyinen salasana']) !!}
				</div>
			</div>
			<div class="form-group">
				<label for="user-new-password" class="control-label col-xs-3">
					Uusi salasana
				</label>
				<div class="col-xs-9">
					{!! Form::password('new_password', ['id' => 'user-new-password', 'class' => 'form-control', 'placeholder' => 'Uusi salasana']) !!}
				</div>
			</div>
			<div class="form-group">
				<label for="user-password_confirmation" class="control-label col-xs-3">
					Uusi salasana uudestaan
				</label>
				<div class="col-xs-9">
					{!! Form::password('new_password_confirmation', ['id' => 'user-password_confirmation', 'class' => 'form-control', 'placeholder' => 'Uusi salasana uudestaan']) !!}
				</div>
			</div>
		</fieldset>

		<fieldset>
			<legend></legend>
			<div class="form-group">
				<div class="col-xs-offset-6 col-xs-6">
					<button type="submit" class="btn btn-primary btn-block">
						Tallenna <span class="glyphicon glyphicon-floppy-disk"></span>
					</button>
				</div>
			</div>
		</fieldset>
		
	{!! Form::close() !!}

@endsection
@extends('layout')

@section('content')
	
	<h1>Salasanan uusiminen</h1>

	{!! Form::open(['method' => 'POST', 'action' => 'Auth\PasswordController@postReset', 'class' => 'form-horizontal']) !!}

		{!! csrf_field() !!}
		<input type="hidden" name="token" value="{{ $token }}">

		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		
		<div class="form-group">
			Syötä sähköpostiosoitteesi varmuuden vuoksi ja uusi salasanasi alle.
		</div>
		
		<fieldset>
			<legend></legend>
			<div class="form-group">
				<label for="user-email" class="control-label col-xs-3">
					Sähköposti
				</label>
				<div class="col-xs-9">
					<input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Sähköposti">
				</div>
			</div>
			<div class="form-group">
				<label for="user-password" class="control-label col-xs-3">
					Uusi salasana
				</label>
				<div class="col-xs-9">
					<input type="password" class="form-control" id="user-password" name="password" placeholder="Uusi salasana">
				</div>
			</div>
			<div class="form-group">
				<label for="user-password_confirmation" class="control-label col-xs-3">
					Uusi salasana uudestaan
				</label>
				<div class="col-xs-9">
					<input type="password" class="form-control" id="user-password_confirmation" name="password_confirmation" placeholder="Uusi salasana uudestaan">
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
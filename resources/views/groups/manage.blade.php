@extends('layout.public')

@section('content')
	<h1>Hallitse ryhmiä</h1>
	<p>
		Jos seuraat johdettua kurssiopetusta opettajan kanssa sinulla voi olla ryhmäkoodi. Voit syöttää sen tällä sivulla.
	</p>
	@if($errors->any())
		<div class="alert alert-danger alert-icon">
			<i class="fa fa-exclamation"></i>
			<div>
				<p>
					Ryhmään liittymisessä tapahtui virhe:
				</p>
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>	
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	@if(@$success)
		<div class="alert alert-success alert-icon">
			<span class="glyphicon glyphicon-ok"></span>
			<div>
				<p>
					Ryhmään <b>{{ $group->title }}</b> liittyminen onnistui!
				</p>
				<p>
					<a href="/">Palaa etusivulle</a>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	@if(Session::get('group_left'))
		<div class="alert alert-success alert-icon">
				<span class="glyphicon glyphicon-ok"></span>
			<div>
				<p>
					Ryhmästä eroaminen onnistui!
				</p>
				<p>
					<a href="/">Palaa etusivulle</a>
				</p>
			</div>
			<div class="clearfix"></div>
		</div>
	@endif
	
	<form action="/groups/manage" method="post">
		{!! csrf_field() !!}
		<div class="form-group">
			<label for="">
				Ryhmäkoodi
			</label>
			<input type="text" class="form-control input-lg" name="group-code" value="{{ old('group-code') }}">
		</div>
		<div class="form-group">
			<button class="btn btn-primary btn-block btn-lg">
				Liity ryhmään <span class="glyphicon glyphicon-chevron-right"></span>
			</button>
		</div>
	</form>
	@if(count($groups))
		<h2>Ryhmäsi</h2>
		<p>
			Olet seuraavissa ryhmissä:
		</p>
		<ul class="user-groups">
			@foreach($groups as $group)
				<li>
					<b>{{ $group->title }}</b><br>
					Opettaja {{ $group->teacher->name }}
					@if($group->teacher->id != Auth::user()->id)
						<a href="/groups/leave/{{ $group->id }}" class="btn btn-danger">
							<span class="glyphicon glyphicon-remove"></span> Poistu ryhmästä
						</a>
					@else
						<a href="/admin#/groups/{{ $group->id }}/edit" class="btn btn-primary" target="_blank">
							<span class="glyphicon glyphicon-edit"></span> Muokkaa ryhmää
						</a>
					@endif
				</li>
			@endforeach
		</ul>
	@endif
@endsection
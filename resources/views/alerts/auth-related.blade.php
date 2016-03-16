@if(!Auth::check())
	<div class="alert alert-info alert-icon login-note">
		<span class="glyphicon glyphicon-info-sign"></span>
		<div>
			<p>
				Jatkaaksesi siitä mihin jäit, <a href="/auth/login"><span class="ul">kirjaudu sisään</span> <span class="glyphicon glyphicon-log-in"></span></a>
			</p>
			<p>
				Jos et ole vielä rekisteröitynyt voit tehdä sen vastatessasi ensimmäiseen kokeeseen.
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
@elseif(Auth::user()->change_password)
	<div class="alert alert-danger alert-icon login-note">
		<i class="fa fa-exclamation"></i>
		<div>
			<p>
				Ylläpito on tehnyt sinulle salasananvaihdon. Sinun tulisi vaihtaa salasanasi mahdollisimman pian.
				
				Voit vaihtaa salasanasi 
				@if(Auth::user()->isAdmin())
					<a href="/admin#/users/{{ Auth::user()->id }}/edit" target="_blank" class="hide-in-mobile-width">
						<span class="ul">täällä</span> <span class="glyphicon glyphicon-edit"></span>
					</a>
					<a href="/auth/edit" class="hide-in-desktop-width">
						<span class="ul">täällä</span> <span class="glyphicon glyphicon-edit"></span>
					</a>
				@else
					<a href="/auth/edit">
						<span class="ul">täällä</span> <span class="glyphicon glyphicon-edit"></span>
					</a>
				@endif
			</p>
		</div>
		<div class="clearfix"></div>
	</div>
@endif
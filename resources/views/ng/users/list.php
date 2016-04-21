<div id="content-sidebar" class="fixed" ng-show="loaded">
	<div class="sidebar-actions">
	
	</div>
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Käyttäjänhallintasivulla voit luoda ja muokata käyttäjätunnuksia, mukaanlukien käyttäjäoikeuksien vaihtamisen.
		</p>
		<p>
			Ylläpitäjän käyttäjäoikeudet sallii käyttäjän kirjautumisen tähän ylläpitopaneeliin. Ylläpitäjä voi siis hallita kursseja, kysymyksiä ja koesuoritusten palautteenantoa. Ole tarkka kenelle annat ylläpitäjän oikeudet.
		</p>
		<p>
			Opettajan käyttäjäoikeudet sallii käyttäjän luoda ryhmiä/luokkia joihin on liitetty tietyt kurssit. Toiset käyttäjät voivat liittyä näihin ryhmiin jolloin heidän koesuorituksensa näkyvät ylläpitopaneelissa opettajalle. Opettaja ei voi luoda tai muuttaa kursseja ja kokeita.
		</p>
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<h1>Käyttäjät</h1>
	<div class="actions-row">
		<div class="pull-right" style="text-align: right">
			<a href="#/users/new" class="btn btn-success">
				<span class="glyphicon glyphicon-plus"></span> Lisää uusi käyttäjä
			</a>
		</div>
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae käyttäjiä" class="form-control search-filter">
		</div>
		<div class="user-toggles">
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level == undefined, 'btn-default': usersFilter.access_level != undefined}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="undefined"> Näytä kaikki
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level == 'USER', 'btn-default': usersFilter.access_level != 'USER'}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="'USER'"> Näytä vain käyttäjät
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level === 'TEACHER', 'btn-default': usersFilter.access_level !== 'TEACHER'}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="'TEACHER'"> Näytä vain opettajat
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level === 'ADMIN', 'btn-default': usersFilter.access_level !== 'ADMIN'}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="'ADMIN'"> Näytä vain ylläpitäjät
				</label>
			</div>
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px">ID</td>
				<td style="min-width:12%">Käyttäjä nimi</td>
				<td style="width:23%">Sähköposti</td>
				<td>Koesuoritukset</td>
				<td style="width:180px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="user in users | filter : searchFilter | filter : usersFilter">
				<td style="font-weight: bold; background:#fafafa">[[ user.id ]]</td>
				<td>
					[[ user.name ]]
				</td>
				<td>
					<div class="pull-right">
						<div ng-if="user.id == userData.user.id" class="label label-info">Sinä</div>
						<div ng-if="user.access_level == 'ADMIN'" class="label label-primary">Ylläpitäjä</div>
						<div ng-if="user.access_level == 'TEACHER'" class="label label-warning">Opettaja</div>
					</div>
					<div class="info">
						[[ user.email ]]
					</div>
				</td>
				<td style="text-align: left">
					<div class="pull-right">
						<a href="#/archive?q=nimi:&quot;[[ user.name ]]&quot;&amp;replied=all&amp;discarded=show">
							Näytä tarkemmin
						</a>
					</div>
					Suorittanut <b>[[ user.archives.length ]]</b> koetta:
					<b>[[ user.tests_passed ]]</b> läpäisty /
					<b>[[ user.tests_completed ]]</b> täysin oikein
				</td>
				<td>
					<a href="#/users/[[ user.id ]]/edit" class="btn btn-primary btn-sm">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<button class="btn btn-danger btn-sm" ng-if="user.id != userData.user.id" ng-click="delete(user)">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</button>
				</td>
			</tr>
			<tr ng-hide="(users | filter : searchFilter | filter : usersFilter).length > 0">
				<td colspan="5" style="text-align: center;">
					<b>Ei tuloksia.</b>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="load-placeholder" ng-show="!loaded">
	<h3>
		<img src="/img/ajax-loader.gif" alt=""> Ladataan...
	</h3>
</div>

<div class="modal fade" id="modal-delete-confirmation">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Poiston varmistus</h4>
			</div>
			<div class="modal-body" style="text-align:center;font-size:120%">
				<p>
					Oletko varma, että haluat poistaa käyttäjän <b>[[ modal_info.user.name ]]</b>?
				</p>
				<p>
					Toiminto poistaa myös käyttäjän koesuoritukset eikä sitä ei voi peruuttaa.
				</p>
			</div>
			<div class="modal-footer">
				<div ng-if="!processing">
					<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
					<button type="button" class="btn btn-danger" ng-click="confirmed_delete()">
						<span class="glyphicon glyphicon-trash"></span> Poista käyttäjä
					</button>
				</div>
				<div ng-if="processing">
					<img src="/img/ajax-loader.gif" alt="" style="width: 36px">
				</div>
			</div>
		</div>
	</div>
</div>
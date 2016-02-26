<div id="content-sidebar" class="fixed" ng-show="loaded">
	<div class="sidebar-actions">
	
	</div>
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Käyttäjänhallintasivulla voit luoda uusia käyttäjätunnuksia sekä muokata olemassa olevia. Voit myös asettaa käyttäjän ylläpitäjäksi.
		</p>
		<p>
			Ylläpitäjän käyttäjäoikeudet sallii käyttäjän kirjautumisen tähän ylläpitopaneeliin. Ylläpitäjä voi siis hallita kursseja, kysymyksiä ja koesuoritusten palautteenantoa. Ole tarkka kenelle annat ylläpitäjän oikeudet.
		</p>
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<div class="breadcrumbs">
		<ol class="breadcrumb">
			<li><a href="#/">Ylläpitopaneeli</a></li>
			<li>Käyttäjät</li>
		</ol>
	</div>
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
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level == 0, 'btn-default': usersFilter.access_level != 0}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="0"> Näytä käyttäjät
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': usersFilter.access_level === 1, 'btn-default': usersFilter.access_level !== 1}">
					<input type="radio" ng-model="usersFilter.access_level" ng-value="1"> Näytä ylläpitäjät
				</label>
			</div>
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px">ID</td>
				<td>Käyttäjän tiedot</td>
				<td style="width:32%">Koesuoritukset</td>
				<td style="width:180px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="user in users | filter : searchFilter | filter : usersFilter">
				<td style="font-weight: bold; background:#fafafa">[[ user.id ]]</td>
				<td>
					<div class="pull-right">
						<div ng-if="user.id == userData.user.id" class="label label-info">Sinä</div>
						<div ng-if="user.access_level == 1" class="label label-primary">Ylläpitäjä</div>
					</div>
					<div class="info">
						<a href="#/users/[[ user.id ]]">
							[[ user.name ]]
						</a>
						([[ user.email ]])
					</div>
				</td>
				<td style="text-align: left">
					<b>[[ user.tests_completed ]] oikein</b> / [[ user.archives.length ]] kokeesta
				</td>
				<td>
					<a href="#/users/[[ user.id ]]/edit" class="btn btn-primary btn-sm">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<a href="#/users/delete/[[ user.id ]]" class="btn btn-danger btn-sm" ng-if="user.id != userData.user.id">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</a>
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
<div id="content-sidebar" class="fixed" ng-show="loaded">
	<div class="sidebar-actions">
	
	</div>
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Ryhmät ovat tarkoitettu helpottamaan opettajan johdolla vedettävää opetusta. Käyttäjät voivat liittyä ryhmiin käyttämällä ryhmän liittymiskoodia jonka jälkeen kaikki heidän koesuorituksensa näkyvät opettajalle.
		</p>
		<p ng-if="userData.user.access_level == 'ADMIN'">
			Voit luoda opettajan käyttäjätunnuksen käyttäjähallinnasta. Käyttäjätunnus opettajan oikeuksilla sallii tämän vain tarkastella koesuorituksia ja lisätä tai poistaa omia ryhmiään.
		</p>
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<h1>Ryhmät</h1>
	<div class="actions-row">
		<div class="pull-right" style="text-align: right">
			<a href="#/groups/new" class="btn btn-success">
				<span class="glyphicon glyphicon-plus"></span> Lisää uusi ryhmä
			</a>
		</div>
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae ryhmiä" class="form-control search-filter">
		</div>
		<div class="user-toggles">
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px">ID</td>
				<td style="width:22%">Ryhmän nimi</td>
				<td style="width:15%">Ryhmän opettaja</td>
				<td>Oppilaita</td>
				<td style="width:15%">Koodi</td>
				<td style="width:180px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="group in groups | filter : searchFilter | filter : filter">
				<td style="font-weight: bold; background:#fafafa">[[ group.id ]]</td>
				<td>
					<div class="pull-right">
						<div ng-if="group.teacher_id == userData.user.id" class="label label-info">Ryhmäsi</div>
					</div>
					<div class="info">
						[[ group.title ]]
					</div>
				</td>
				<td>
					[[ group.teacher.name ]]
				</td>
				<td>
					[[ group.users.length - 1 ]]
					<a ng-click="showGroupUsers(group)" title="Näytä oppilaat" class="btn btn-sm btn-default" style="margin-left: 10px">
						<span class="glyphicon glyphicon-search"></span>
					</a>
				</td>
				<td>
					[[ group.code ]]
				</td>
				<td>
					<a href="#/groups/[[ group.id ]]/edit" class="btn btn-primary btn-sm">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<button class="btn btn-danger btn-sm" ng-if="group.id != userData.group.id" ng-click="delete(group)">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</button>
				</td>
			</tr>
			<tr ng-hide="(groups | filter : searchFilter | filter : filter).length > 0">
				<td colspan="6" style="text-align: center;">
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
					Oletko varma, että haluat poistaa ryhmän <b>[[ modal_info.group.title ]]</b>?
				</p>
				<p>
					Toimintoa ei voi peruuttaa.
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

<div class="modal fade" id="modal-group-students">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ryhmä [[ modal_info.group.title ]]</h4>
			</div>
			<div class="modal-body" style="font-size:120%">
				<h4>Opettaja</h4>
				<p>
					[[ modal_info.group.teacher.name ]]
				</p>
				<h4>Oppilaat</h4>
				<ul>
					<li ng-repeat="user in modal_info.group.users" ng-if="user.id != modal_info.group.teacher.id">
						[[ user.name ]]
					</li>
					<li ng-if="modal_info.group.users.length <= 1">
						Ei oppilaita.
					</li>
				</ul>
			</div>
			<div class="modal-footer">
				<div ng-if="!processing">
					<button type="button" class="btn btn-default" data-dismiss="modal">Sulje</button>
				</div>
				<div ng-if="processing">
					<img src="/img/ajax-loader.gif" alt="" style="width: 36px">
				</div>
			</div>
		</div>
	</div>
</div>
<div id="content-sidebar" class="fixed" ng-show="loaded">
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Sisältösivuille voi lisätä muuta sivustoa tukevaa materiaalia.
		</p>
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<h1><b>Sisältösivut</b></h1>
	<div class="actions-row">
		<div class="pull-right" style="text-align: right">
			<a href="#/pages/new" class="btn btn-success">
				<span class="glyphicon glyphicon-plus"></span> Lisää uusi sivu
			</a>
		</div>
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae sivuja" class="form-control search-filter">
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px">ID</td>
				<td style="min-width:180px;max-width:360px;">Sivun otsikko</td>
				<td></td>
				<td style="width:110px">Viite</td>
				<td>Sisällön esikatselu</td>
				<td style="width:260px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="page in pages | filter : searchFilter" class="min-height">
				<td style="font-weight: bold;background:#fafafa">[[ page.id ]]</td>
				<td class="block-level-links">
					<a href="#/pages/[[ page.id ]]/edit">
						[[ page.title ]]
					</a>
					<span class="clearfix"></span>
				</td>
				<td>
					<div class="label label-success" ng-if="page.id == 1 || page.pinned == 1">Navigaatiossa</div>
					<div class="label label-primary" ng-if="page.sidebar_body.length > 0">Sivupalkki</div>
				</td>
				<td>
					[[ page.tag ]]
				</td>
				<td>
					<div ng-bind-html="page.body | trusted" class="limited-height-preview"></div>
				</td>
				<td>
					<a href="/page/[[ page.id ]]/[[ page.tag ]]" class="btn btn-primary btn-sm" target="_blank">
						<span class="glyphicon glyphicon-search"></span> Avaa sivu
					</a>
					<a href="#/pages/[[ page.id ]]/edit" class="btn btn-success btn-sm">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<button type="button" class="btn btn-danger btn-sm" ng-click="delete(page)" ng-if="page.id != 1">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</button>
				</td>
			</tr>
			<tr ng-hide="(pages | filter : searchFilter).length > 0">
				<td colspan="6" style="text-align: center;">
					<b>Ei tuloksia.</b>
				</td>
			</tr>
		</tbody>
	</table>
	<hr>
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
					Oletko varma, että haluat poistaa sivun <b>"[[ modal_info.page.title ]]"</b>?
				</p>
				<p>
					Toimintoa ei voi peruuttaa.
				</p>
			</div>
			<div class="modal-footer">
				<div ng-if="!processing">
					<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
					<button type="button" class="btn btn-danger" ng-click="confirmed_delete()">
						<span class="glyphicon glyphicon-trash"></span> Poista sivu
					</button>
				</div>
				<div ng-if="processing">
					<img src="/img/ajax-loader.gif" alt="" style="width: 36px">
				</div>
			</div>
		</div>
	</div>
</div>
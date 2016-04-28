<div id="content-sidebar" class="fixed" ng-show="loaded">
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Kurssit ovat kokonaisuus kokeita järjestetyssä sarjassa. Kurssin suorittaja voi edetä kurssilla vastaamalla oikein ainakin 50% kysymyksistä kokeessa.
		</p>
		<p>
			Kurssin voi myös tallentaa luonnoksena jolloin käyttäjät eivät voi vielä suorittaa sitä. Hyvä vaihtoehto silloin kun kurssin kokeita ollaan vielä rakentamassa.
		</p>
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<h1><b>Kurssit</b></h1>
	<div class="actions-row">
		<div class="pull-right" style="text-align: right">
			<a href="#/courses/new" class="btn btn-success">
				<span class="glyphicon glyphicon-plus"></span> Lisää uusi kurssi
			</a>
		</div>
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae kursseja" class="form-control search-filter">
		</div>
		<div class="replied-to-toggles">
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': courseFilter.published === undefined, 'btn-default': courseFilter.published !== undefined}">
					<input type="radio" ng-model="courseFilter.published" ng-value="undefined"> Näytä kaikki
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': courseFilter.published == 1, 'btn-default': courseFilter.published != 1}">
					<input type="radio" ng-model="courseFilter.published" ng-value="1"> Vain julkaistut
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': courseFilter.published == 0, 'btn-default': courseFilter.published != 0}">
					<input type="radio" ng-model="courseFilter.published" ng-value="0"> Vain luonnokset/piilotetut
				</label>
			</div>
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px">ID</td>
				<td style="min-width:180px;max-width:260px;">Kurssin otsikko</td>
				<td style="width:100px;"></td>
				<td>Kuvaus</td>
				<td style="min-width:200px;">Kurssin kokeet</td>
				<td style="width:210px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="course in courses | coursefilter : courseFilter | filter : searchFilter" class="min-height">
				<td style="font-weight: bold;background:#fafafa">[[ course.id ]]</td>
				<td class="block-level-links">
					<a href="#/courses/[[ course.id ]]">
						[[ course.title ]]
					</a>
					<span class="clearfix"></span>
				</td>
				<td class="status-labels">
					<div class="label label-success" ng-if="course.published == 1 && course.tests.length > 0">
						Julkaistu
					</div>
					<div class="label label-warning" ng-if="course.published == 1 && course.tests.length == 0">
						Julkaistu mutta piilotettu
					</div>
					<div class="label label-warning" ng-if="course.published == 0 && course.tests.length > 0">
						Luonnos
					</div>
					<div class="label label-danger" ng-if="course.published == 0 && course.tests.length == 0">
						Piilotettu
					</div>
				</td>
				<td ng-bind-html="course.description">[[ course.description ]]</td>
				<td class="list-no-padding list-scroll">
					<ol>
						<li ng-repeat="test in course.tests">
							<a href="#/tests/[[ test.id ]]/edit">[[ test.title ]]</a>
						</li>
					</ol>
					<span ng-show="course.tests.length == 0">
						<span style="font-weight: bold;color: #BC2020">Ei kokeita!</span><br>
						<span style="color: #545454">Kurssia ei näytetä.</span>
					</span>
				</td>
				<td>
					<a href="#/courses/[[ course.id ]]" class="btn btn-primary btn-xs">
						<span class="glyphicon glyphicon-search"></span> Näytä
					</a>
					<a href="#/courses/[[ course.id ]]/edit" class="btn btn-success btn-xs">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<button type="button" class="btn btn-danger btn-xs" ng-click="delete(course)">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</button>
				</td>
			</tr>
			<tr ng-hide="(courses | filter : searchFilter).length > 0">
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
					Oletko varma, että haluat poistaa kurssin <b>"[[ modal_info.course.title ]]"</b>?
				</p>
				<p>
					Toimintoa ei voi peruuttaa.
				</p>
			</div>
			<div class="modal-footer">
				<div ng-if="!processing">
					<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
					<button type="button" class="btn btn-danger" ng-click="confirmed_delete()">
						<span class="glyphicon glyphicon-trash"></span> Poista kurssi
					</button>
				</div>
				<div ng-if="processing">
					<img src="/img/ajax-loader.gif" alt="" style="width: 36px">
				</div>
			</div>
		</div>
	</div>
</div>
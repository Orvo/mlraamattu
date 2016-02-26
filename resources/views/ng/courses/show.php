<div id="content-sidebar" ng-show="loaded">
	<div class="sidebar-actions">
		<div class="form-group">
			<a href="#/courses/" class="btn btn-default btn-block">
				<span class="glyphicon glyphicon-chevron-left"></span> Palaa kurssilistaukseen
			</a>
		</div>
		
		<div class="form-group">
			<p>
				Muokkaa kurssin tietoja, julkaisutilaa ja kokeiden järjestystä.
			</p>
			<a href="#/courses/[[ course.id ]]/edit" class="btn btn-primary btn-block btn-lg">
				<span class="glyphicon glyphicon-edit"></span> Muokkaa kurssia
			</a>
		</div>
		
		<div class="form-group">
			<p>
				Luo uusi koe tälle kurssille.
			</p>
			<a href="#/tests/new/[[ course.id ]]" class="btn btn-success btn-block btn-lg">
				<span class="glyphicon glyphicon-plus"></span> Lisää uusi koe
			</a>
		</div>
	</div>
	<hr>
	<div class="sidebar-help">
		
	</div>
</div>
<div id="content-main" ng-show="loaded">
	<h1><b>Kurssi</b> / [[ course.title ]]</h1>
	<p ng-bind-html="course.description"></p>
	<div class="alert alert-warning" ng-if="!course.published">
		<b>Huom!</b> Tämä kurssi on tällä hetkellä piilotettu. <a href="#/courses/[[ course.id ]]/edit">Muokkaa</a> kurssia jos haluat julkaista sen.
	</div>
	<div class="actions-row">
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae kursseja" class="form-control search-filter">
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px"></td>
				<td style="min-width:160px;max-width:260px;">Kokeen otsikko</td>
				<td>Kuvaus</td>
				<td style="min-width:200px;">Kysymykset</td>
				<td style="width:180px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="(key, test) in course.tests | filter : searchFilter">
				<td style="font-weight: bold; text-align: right; background:#fafafa">[[ key + 1 ]].</td>
				<td class="block-level-links">
					<a href="#/tests/[[ test.id ]]/edit">
						[[ test.title ]]
					</a>
				</td>
				<td>
					<p ng-bind-html="test.description"></p>
				</td>
				<td class="list-no-padding">
					<ol>
						<li ng-repeat="question in test.questions">[[ question.title ]]</li>
					</ol>
					<span ng-show="test.questions.length == 0">Ei kysymyksiä</span>
				</td>
				<td>
					<a href="#/tests/[[ test.id ]]/edit" class="btn btn-primary btn-sm">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<button type="button" class="btn btn-danger btn-sm" ng-click="delete(test)">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</button>
				</td>
			</tr>
			<tr ng-hide="(course.tests | filter : searchFilter).length > 0">
				<td colspan="5" style="text-align: center;">
					<span ng-if="course.tests.length == 0">
						<span style="font-weight: bold; color: #BC2020;display:inline-block;margin-right:1em">Ei kokeita!</span>
						<a href="#/tests/new/[[ course.id ]]" class="btn btn-success btn-sm shadowed">
							<span class="glyphicon glyphicon-plus"></span> Lisää uusi
						</a>
					</span>
					<span style="font-weight: bold;" ng-if="course.tests.length > 0">
						Ei tuloksia.
					</span>
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
					Oletko varma, että haluat poistaa kokeen <b>"[[ modal_info.test.title ]]"</b>?
				</p>
				<p>
					Toimintoa ei voi peruuttaa.
				</p>
			</div>
			<div class="modal-footer">
				<div ng-if="!processing">
					<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
					<button type="button" class="btn btn-danger" ng-click="confirmed_delete()">
						<span class="glyphicon glyphicon-trash"></span> Poista koe
					</button>
				</div>
				<div ng-if="processing">
					<img src="/img/ajax-loader.gif" alt="" style="width: 36px">
				</div>
			</div>
		</div>
	</div>
</div>
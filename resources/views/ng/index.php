<h1>Ylläpitopaneeli</h1>
<p>
	Tervetuloa ylläpitopaneeliin.
</p>
<div class="recent-edits">
	<div class="list">
		<div class="wrapper">
			<h4>Tarkistamattomia koesuorituksia [[ recent.archive_new ]] kpl</h4>
			<div class="inner">
				<table class="table">
					<thead>
						<tr>
							<td style="width:150px">Suorittaja</td>
							<td style="width:150px">Suoritusaika</td>
							<td>Kurssi / Koe</td>
							<td style="width:170px">Tulos</td>
							<td style="width:110px">Toiminnot</td>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="item in recent.archive" ng-show="loaded">
							<td>
								[[ item.user.name ]]
							</td>
							<td>
								[[ item.created_at | convertToDate | date:"dd.MM.yyyy 'klo' HH:mm" ]]
							</td>
							<td>
								<a href="#/courses/[[ item.test.course.id ]]">
									<b>[[ item.test.course.title ]]</b> #[[ item.test.order ]]
								</a>
								<span class="separator-slash">/</span>
								<a href="#/tests/[[ item.test.id ]]/edit">
									[[ item.test.title ]] 
								</a>
							</td>
							<td class="archive-test-result">
								<div class="clearfix">
									<span class="icon" ng-class="{'all-correct': item.data.all_correct, 'partially-correct': !item.data.all_correct && item.data.num_correct > 0, 'incorrect': item.data.num_correct == 0}">
										<span class="glyphicon glyphicon-ok-circle" ng-show="item.data.all_correct"></span>
										<span class="glyphicon glyphicon-remove-circle" ng-show="!item.data.all_correct"></span>
									</span>
									<span class="number">
										<b>[[ item.data.num_correct ]] / [[ item.data.total ]]</b> oikein
									</span>
								</div>
							</td>
							<td>
								<a href="#/archive/[[ item.id ]]/reply" class="btn btn-success btn-sm btn-block">
									<span class="glyphicon glyphicon-ok"></span> Vastaa
								</a>
							</td>
						</tr>
						<tr ng-if="!loaded">
							<td colspan="5" style="text-align:center;font-weight: bold;">
								<img src="/img/ajax-loader.gif" alt="" style="height:38px;"> Ladataan...
							</td>
						</tr>
						<tr ng-if="loaded && recent.archive.length == 0">
							<td colspan="5" style="text-align:center;font-weight: bold;">
								Ei tarkistamattomia suorituksia.
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	
	<div class="list" ng-if="userData.user.access_level == 'ADMIN'">
		<div class="wrapper">
			<h4>Viimeksi muokatut kokeet</h4>
			<div class="inner">
				<table class="table">
					<thead>
						<tr>
							<td style="width:30%">Koe</td>
							<td>Kurssi</td>
							<td style="width:20%">Muokattu</td>
							<td style="width:110px">Toiminnot</td>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="test in recent.tests" ng-show="loaded">
							<td>
								<b>[[ test.title ]]</b>
								<br>
								[[ test.questions.length ]] kysymystä
							</td>
							<td>
								<a href="#/courses/[[ test.course.id ]]">
									[[ test.course.title ]]
								</a>
							</td>
							<td>
								[[ test.updated_at | date:"dd.MM.yyyy 'klo' HH:mm" ]]
							</td>
							<td>
								<a href="#/tests/[[ test.id ]]/edit" class="btn btn-block btn-primary btn-sm">
									<span class="glyphicon glyphicon-search"></span> Näytä
								</a>
							</td>
						</tr>
						<tr ng-if="!loaded">
							<td colspan="4" style="text-align:center;font-weight: bold;">
								<img src="/img/ajax-loader.gif" alt="" style="height:38px;"> Ladataan...
							</td>
						</tr>
						<tr ng-if="loaded && recent.tests.length == 0">
							<td colspan="4" style="text-align:center;font-weight: bold;">
								Ei tuloksia.
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="list" ng-if="userData.user.access_level == 'ADMIN'">
		<div class="wrapper">
			<h4>Viimeksi muokatut kurssit</h4>
			<div class="inner">
				<table class="table">
					<thead>
						<tr>
							<td style="width:30%">Kurssin otsikko</td>
							<td></td>
							<td style="width:20%">Muokattu</td>
							<td style="width:110px">Toiminnot</td>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="course in recent.courses" ng-show="loaded">
							<td>
								[[ course.title ]]
							</td>
							<td>
								[[ course.tests.length ]] koetta
							</td>
							<td>
								[[ course.updated_at | date:"dd.MM.yyyy 'klo' HH:mm" ]]
							</td>
							<td>
								<a href="#/courses/[[ course.id ]]" class="btn btn-block btn-primary btn-sm">
									<span class="glyphicon glyphicon-search"></span> Näytä
								</a>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="text-align:center;font-weight: bold;" ng-show="!loaded">
								<img src="/img/ajax-loader.gif" alt="" style="height:38px;"> Ladataan...
							</td>
						</tr>
						<tr ng-if="loaded && recent.courses.length == 0">
							<td colspan="4" style="text-align:center;font-weight: bold;">
								Ei tuloksia.
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
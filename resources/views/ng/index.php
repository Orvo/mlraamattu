<h1>Ylläpitopaneeli</h1>
<p>
	Tervetuloa ylläpitopaneeliin.
</p>
<div class="recent-edits">
	<div class="list col-lg-6">
		<div class="wrapper">
			<h4>Viimeksi muokatut kokeet</h4>
			<div class="inner">
				<table class="table">
					<thead>
						<tr>
							<td>Koe</td>
							<td style="width:30%">Kurssi</td>
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
								<a href="#/tests/[[ test.id ]]/edit" class="btn btn-primary btn-sm">
									<span class="glyphicon glyphicon-search"></span> Näytä
								</a>
							</td>
						</tr>
						<tr>
							<td colspan="4" style="text-align:center;font-weight: bold;" ng-show="!loaded">
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
	<div class="list col-lg-6">
		<div class="wrapper">
			<h4>Viimeksi muokatut kurssit</h4>
			<div class="inner">
				<table class="table">
					<thead>
						<tr>
							<td>Kurssin otsikko</td>
							<td style="width:10%"></td>
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
								<a href="#/courses/[[ course.id ]]" class="btn btn-primary btn-sm">
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
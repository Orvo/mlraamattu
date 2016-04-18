<div id="content-sidebar">
	<div class="sidebar-help">
		<h3>Ohjeet</h3>
		<p>
			Voit rajata koesuorituksia kirjoittamalla hakuehtoja kenttään tai klikkaamalla rajauspainikkeita ja -valikkoja.
		</p>
		<h4>Kuittaus</h4>
		<p>
			Koesuorituksen voi myös kuitata jos et siihen halua vastata. Kuittaamalla suorituksen poistat sen oletusnäkymästä ja sallit käyttäjän jatkaa kurssin suoritusta vaikkei käyttäjä olisi saanut tarpeeksi kysymyksiä oikein.
		</p>
		<p>
			Kuittauksesta käyttäjälle ei lähetetä huomautusta ja halutessasi voit silti vielä antaa koepalautetta myöhemmässä vaiheessa.
		</p>
		<h4>Koepalaute</h4>
		<p>
			Koepalautteen antaminen auttaa kokeiden suorittajia oppimaan paremmin. Vaikka järjestelmä tarkistaakin koevastaukset automaattisesti, kirjallisen vastauksen tarkistus ei onnistu koneellisesti ja sen tarkistus tulee suorittaa koepalautteen antamisen kautta.
		</p>
		<p>
			Koepalautteen antaminen lisäksi sallii käyttäjän jatkaa kurssia vaikkei käyttäjä olisi saanut vähintään puolta kysymyksistä oikein.
		</p>
		<p>
			Palautteen lähetyksen yhteydessä kokeen suorittajalle lähetetään sähköpostihuomautus annetusta palautteesta.
		</p>
	</div>
</div>
<div id="content-main">
	<h1>Koesuoritukset</h1>
	<div class="alert-box success" ng-show="save_success">
		<h4><span class="glyphicon glyphicon-ok"></span> Palautteen lähetys onnistui!</h4>
	</div>
	<div class="actions-row">
		<div>
			<input type="text" ng-model="searchFilter" placeholder="Hae koesuorituksia" class="form-control search-filter">
		</div>
		<div class="replied-to-toggles">
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': archiveFilter.replied_to == 0, 'btn-default': archiveFilter.replied_to != 0}">
					<input type="radio" ng-model="archiveFilter.replied_to" ng-value="0"> Näytä vastaamattomat
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': archiveFilter.replied_to == 1, 'btn-default': archiveFilter.replied_to != 1}">
					<input type="radio" ng-model="archiveFilter.replied_to" ng-value="1"> Näytä vastatut
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-warning': archiveFilter.replied_to === undefined, 'btn-default': archiveFilter.replied_to !== undefined}">
					<input type="radio" ng-model="archiveFilter.replied_to" ng-value="undefined"> Näytä kaikki
				</label>
			</div>
		</div>
		<div class="discarded-toggles">
			<div class="radio">
				<label class="btn" ng-class="{'btn-info': archiveFilter.discarded == 0, 'btn-default': archiveFilter.discarded != 0}">
					<input type="radio" ng-model="archiveFilter.discarded" ng-value="0"> Piilota kuitatut
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-info': archiveFilter.discarded === undefined, 'btn-default': archiveFilter.discarded !== undefined}">
					<input type="radio" ng-model="archiveFilter.discarded" ng-value="undefined"> Näytä kuitatut
				</label>
			</div>
			<div class="radio">
				<label class="btn" ng-class="{'btn-info': archiveFilter.discarded == 1, 'btn-default': archiveFilter.discarded != 1}">
					<input type="radio" ng-model="archiveFilter.discarded" ng-value="1"> Näytä vain kuitatut
				</label>
			</div>
		</div>
		<div class="archive-select-filters">
			<label>Rajaa suorituksia</label>
			<div>
				<select class="form-control"
					ng-model="select_filters.course"
					ng-change="course_filter_changed()"
					ng-options="course as course.title for course in courses track by course.title">
					<option ng-value="undefined">Rajaa kurssin mukaan</option>
				</select>
				<select class="form-control"
					ng-model="select_filters.test"
					ng-change="test_filter_changed()"
					ng-options="test as test.title group by test.course.title for test in tests">
					<option ng-value="undefined">Rajaa kokeen mukaan</option>
				</select>
				<button type="button" class="btn btn-primary"
					ng-if="select_filters.course.id !== undefined || select_filters.test.id !== undefined"
					ng-click="reset_select_filter()">
					<span class="glyphicon glyphicon-remove-sign"></span> Nollaa rajaus
				</button>
			</div>
		</div>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px;"></td>
				<td style="width:170px">Kokeen suorittaja</td>
				<td style="width:180px">Suoritusaika</td>
				<td style="min-width:150px">Kurssi / Koe</td>
				<td style="width:20%">Tulos</td>
				<td class="list-actions" style="width:180px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="(key, item) in archive | keyfilter : ({ key: 'user.name', value: searchName }) | filter : searchFilterParsed | filter : archiveFilter : true" ng-class="{'missing-test':!item.test}">
				<td style="font-weight: bold;text-align: right;">[[ key + 1 ]].</td>
				<td>
					[[ item.user.name ]]
				</td>
				<td>
					[[ item.created_at | date:  "dd.MM.yyyy 'klo' HH:mm" ]]
				</td>
				<td>
					<a href="#/courses/[[ item.test.course.id ]]">
						<b>[[ item.test.course.title ]]</b> #[[ item.test.order ]]
					</a>
					<span class="separator-slash">/</span>
					<a href="#/tests/[[ item.test.id ]]/edit">
						[[ item.test.title ]] 
					</a>
					<div class="labels pull-right">
						<span class="label label-success" ng-if="item.replied_to">Vastattu</span>
						<span class="label label-warning" ng-if="item.discarded && item.test.autodiscard == 0">Kuitattu</span>
						<span class="label label-warning" ng-if="item.discarded && item.test.autodiscard != 0">Automaattinen kuittaus</span>
					</div>
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
				<td class="list-actions">
					<div ng-if="!item.replied_to">
						<a href="#/archive/[[ item.id ]]/reply" class="btn btn-success btn-sm">
							<span class="glyphicon glyphicon-ok"></span> Vastaa
						</a>
						<button type="button" class="btn btn-warning btn-sm" ng-click="discard(item)" ng-if="!item.discarded">
							<span class="glyphicon glyphicon-remove"></span> Kuittaa
						</button>
					</div>
					<div ng-if="item.replied_to">
						<button class="btn btn-primary btn-sm" ng-click="show_feedback(item)">
							<span class="glyphicon glyphicon-search"></span> Näytä
						</button>
					</div>
				</td>
			</tr>
			<tr ng-if="(archive | keyfilter : ({ key: 'user.name', value: searchName }) | filter : searchFilterParsed | filter : archiveFilter : true).length == 0">
				<td colspan="7" style="text-align: center;font-weight: bold;">
					Ei suorituksia annetuilla hakuehdoilla
				</td>
			</tr>
		</tbody>
	</table>
</div>

<div class="modal fade" id="modal-display-feedback">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Koepalaute / [[ modal_info.user.name ]] / [[ modal_info.test.title ]]</h4>
			</div>
			<div class="modal-body">
				<ol>
					<li ng-repeat="question in modal_info.test.questions" ng-if="modal_info.data.feedback[question.id]">
						<div class="pull-right">
							<div class="label label-success" ng-if="modal_info.data.validation[question.id].correct">
								Oikein
							</div>
							<div class="label label-warning" ng-if="!modal_info.data.validation[question.id].correct && modal_info.data.validation[question.id].partial > 0">
								Osittain oikein
							</div>
							<div class="label label-danger" ng-if="!modal_info.data.validation[question.id].correct && (modal_info.data.validation[question.id].partial === 0 || modal_info.data.validation[question.id].partial === undefined)">
								Väärin
							</div>
						</div>
						<div style="font-weight: bold;font-size: 110%;padding-bottom:0.25em">[[ question.title ]]</div>
						<div>
							[[ modal_info.data.feedback[question.id] ]]
						</div>
					</li>
				</ol>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Sulje</button>
			</div>
		</div>
	</div>
</div>
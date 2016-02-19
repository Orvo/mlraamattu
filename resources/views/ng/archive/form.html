<form ng-submit="submit()" ng-if="loaded">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/archive/" class="btn btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Palaa koesuorituksiin
				</a>
			</div>

			<hr>
			<div class="form-group">
				<div ng-hide="processing">
					<button type="submit" class="btn btn-primary btn-block btn-lg">
						<span class="glyphicon glyphicon-send"></span> Lähetä palautetta
					</button>
				</div>
				<div ng-show="processing" style="text-align: center">
					<img src="/img/ajax-loader.gif" alt="">
				</div>
			</div>
			<div class="form-group" ng-if="save_success === false">
				<div class="alert alert-danger">
					<div ng-repeat="error in errors" ng-bind-html="error"></div>
					<hr style="margin: 0.4em 0 0.52em 0">
					Tallennus epäonnistui! Yritä uudelleen.
				</div>
			</div>
		</div>
		
		<div class="sidebar-help">
			<h4>Ohjeet</h4>
			<p>
				Syötä koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kenttään. Voit jättää ne kentät tyhjäksi joihin et halua antaa palautetta, mutta sinun täytyy antaa palautetta vähintään yhteen kysymykseen.
			</p>
			<p>
				Palautteen lähetyksen yhteydessä kokeen suorittajalle lähetetään sähköpostihuomautus annetusta palautteesta. Viestiin sisällytetään vain ne kysymykset joihin olet antanut palautetta.
			</p>
			<h4>Koepalaute</h4>
			<p>
				Koepalautteen antaminen auttaa kokeiden suorittajia oppimaan paremmin. Vaikka järjestelmä tarkistaakin koevastaukset automaattisesti, kirjallisen vastauksen tarkistus ei onnistu koneellisesti ja sen tarkistus tulee suorittaa koepalautteen antamisen kautta.
			</p>
			<p>
				Koepalautteen antaminen lisäksi sallii käyttäjän jatkaa kurssia vaikkei käyttäjä olisi saanut vähintään puolta kysymyksistä oikein.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			Koepalautteen lähetys / <b>[[ data.user.name ]] - [[ data.test.title ]]</b></span>
		</h1>
		<h3 class="test-result-box">
			Kokeen tulos:
			<span ng-if="data.archive.all_correct" style="color:#379315;">Kaikki oikein</span>
			<span ng-if="!data.archive.all_correct && data.archive.num_correct > 0" style="color:#E19C28;">Osittain oikein</span>
			<span ng-if="!data.archive.all_correct && data.archive.num_correct == 0" style="color:#A70014;">Kaikki väärin</span>
			<span>
				[[ data.archive.num_correct ]] / [[ data.archive.total ]]
			</span>
		</h3>
		<fieldset>
			<legend>Kysymyskohtainen palaute</legend>
			<ul class="test-feedback-list questions">
				<li class="question active" ng-repeat="(qkey, question) in data.test.questions">
					<div class="info">
						<div class="title-row clearfix">
							<div class="right-aligned">
								<div class="result-badge correct" ng-if="data.validation.validation[question.id].correct">
									<span ng-if="question.type == 'TEXTAREA'">Hyväksytty</span>
									<span ng-if="question.type != 'TEXTAREA'">Oikein</span>
								</div>
								<div class="result-badge partially-correct" ng-if="!data.validation.validation[question.id].correct && data.validation.validation[question.id].partial > 0">
									Osittain oikein
								</div>
								<div class="result-badge incorrect" ng-if="!data.validation.validation[question.id].correct && (data.validation.validation[question.id].partial === 0 || data.validation.validation[question.id].partial === undefined)">
									Väärin
								</div>
							</div>
							<div class="left-aligned">
								<div class="number">[[ (qkey + 1) ]].</div>
								<div class="title" ng-class="{'no-subtitle': question.subtitle.trim().length == 0, 'dimmed': question.title.trim().length == 0}">
									[[ question.title || 'Kysymys puuttuu' ]]
								</div>
								<div class="subtitle">
									[[ question.subtitle.split('\n')[0] ]]
								</div>
							</div>
						</div>
					</div>
					<div class="edit">
						<div class="answers-wrapper clearfix">
							<div class="col-lg-6 test-answer">
								<span>Annettu vastaus:</span>
								<div ng-if="question.type == 'MULTI'">
									<ul>
										<li ng-repeat="answer in data.archive.given_answers[question.id]">
											[[ data.indexed_answers[answer].text ]]
											<span ng-if="!data.indexed_answers[answer].is_correct" style="color:#A80505">
												<span class="glyphicon glyphicon-remove"></span>
											</span>
										</li>
									</ul>
								</div>
								<div ng-if="question.type == 'CHOICE'">
									<ul>
										<li>
											[[ data.indexed_answers[data.archive.given_answers[question.id] ].text ]]
											<span ng-if="!data.indexed_answers[data.archive.given_answers[question.id] ].is_correct" style="color:#A80505">
												<span class="glyphicon glyphicon-remove"></span>
											</span>
										</li>
									</ul>
								</div>
								<div ng-if="question.type == 'MULTITEXT'">
									<ul>
										<li ng-repeat="answer in data.archive.given_answers[question.id]">
											[[ answer ]]
										</li>
									</ul>
								</div>
								<div ng-if="question.type == 'TEXT' || question.type == 'TEXTAREA'">
									<ul>
										<li>
											[[ data.archive.given_answers[question.id] ]]
										</li>
									</ul>
								</div>
							</div>
							<div class="col-lg-6 test-answer" ng-if="question.type != 'TEXTAREA'">
								<span>Oikea vastaus:</span>
								<div>
									<ul>
										<li ng-repeat="answer in question.answers | filter : {is_correct:1}">
											[[ answer.text ]]
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="form-group feedback-field">
							<label class="control-label">Vastauspalaute:</label>
							<textarea class="form-control" elastic ng-model="feedback[question.id]" placeholder="Kirjoita palautetta tai jätä tyhjäksi"></textarea>
						</div>
						
						<div class="clearfix"></div>
					</div>
				</li>
			</ul>
		</fieldset>
	</div>
</form>

<div class="load-placeholder" ng-if="!loaded">
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
					Oletko varma, että haluat poistaa kysymyksen <b>"[[ modal_info.key + 1 ]]. [[ modal_info.question.title ]]"</b>?
				</p>
				<p>
					Lopullinen poisto tapahtuu kokeen tallennuksen yhteydessä, jonka jälkeen toimintoa ei voi peruuttaa.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
				<button type="button" class="btn btn-danger" ng-click="confirmed_delete()">
					<span class="glyphicon glyphicon-trash"></span> Poista kysymys
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="modal-cancel-confirmation">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Poiston varmistus</h4>
			</div>
			<div class="modal-body" style="text-align:center;font-size:120%">
				<p>
					Kysymyksen <b>"[[ modal_info.key + 1 ]]. [[ modal_info.question.title ]]"</b> muokkaus on vielä kesken. Haluatko jatkaa tallentamatta?
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Peruuta</button>
				<button type="button" class="btn btn-warning" ng-click="confirmed_cancel()">
					<span class="glyphicon glyphicon-remove"></span> Älä tallenna
				</button>
			</div>
		</div>
	</div>
</div>

<form ng-submit="submit(data)" ng-if="loaded" class="test-form">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/courses/[[ data.test.course.id ]]" class="btn btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Palaa kurssiin
				</a>
			</div>
			
			<div class="form-group">
				<label>Kurssi johon koe liitetään</label><br>
				<select class="form-control" ng-model="selected_course" ng-if="courses_loaded"
					ng-options="course as course.title for course in data.courses track by course.id"
					ng-change="update_course_selection(selected_course)">
				</select>
				<div ng-if="!courses_loaded" style="text-align: center;">
					<img src="/img/ajax-loader.gif" alt="" style="width: 34px">
				</div>
			</div>
			
			<div class="form-group">
				<button type="button" class="btn btn-success btn-block" ng-click="add_question()" ng-disabled="data.test.questions.length >= num_max_questions || isSorting">
					<span class="glyphicon glyphicon-plus"></span> Lisää uusi kysymys
				</button>
				<div class="help-block center-text" ng-show="data.test.questions.length >= num_max_questions">
					Maksimimäärä kysymyksiä saavutettu
				</div>
			</div>
			
			<div class="form-group">
				<button type="button" class="btn btn-default btn-block" ng-click="startSorting()" ng-if="!isSorting" ng-disabled="data.test.questions.length <= 1">
					<span class="glyphicon glyphicon-sort"></span> Järjestä kysymykset
				</button>
				<button type="button" class="btn btn-default btn-block" ng-click="stopSorting()" ng-if="isSorting">
					<span class="glyphicon glyphicon-sort"></span> Tallenna järjestys
				</button>
			</div>

			<hr>
			<div class="form-group">
				<div ng-hide="processing">
					<button type="submit" class="btn btn-primary btn-block btn-lg" ng-disabled="isSorting">
						<span class="glyphicon glyphicon-floppy-disk"></span> Tallenna
					</button>
				</div>
				<div ng-show="processing" style="text-align: center">
					<img src="/img/ajax-loader.gif" alt="">
				</div>
			</div>
			<div class="form-group" ng-if="save_success || data.errors.messages.length > 0">
				<div class="alert-box success" ng-show="save_success">
					<h4><span class="glyphicon glyphicon-ok"></span> Muutokset tallennettu!</h4>
				</div>
				<div class="alert-box errors" ng-show="data.errors.messages.length > 0">
					<img src="/img/ajax-loader-error.gif" alt="" class="pull-right" ng-show="processing" style="height:40px">
					<h4>Tallennus epäonnistui!</h4>
					<ul>
						<li ng-repeat="error in data.errors.messages">[[ error ]]</li>
					</ul>
				</div>
			</div>
		</div>
		
		<div class="sidebar-help">
			<p>
				Uuden kokeen luonti!
			</p>
			<p>
				Kysymyksiin tehdyt muutokset tulevat voimaan vasta kun hyväksyt ne painamalla "Valmis" painiketta lomakkeen alareunassa. Jos haluat hylätä tekemäsi muutokset paina "Peruuta".
			</p>
			<p>
				Kysymysten poistaminen onnistuu painamalla punaista "Poista" painiketta. Kysymykset poistetaan lopullisesti tallennuksen yhteydessä, jonka jälkeen toiminto on peruuttamaton.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			<span ng-show="!id">Uusi koe</span>
			<span ng-show="id">Muokataan koetta</span>
			<span ng-show="data.test.title">/ <b>[[ data.test.title ]]</b></span>
		</h1>
		<div class="form-group">
			<input type="text" class="form-control input-lg input-block" id="test-title"
				ng-model="data.test.title" ng-class="{'area-has-error': data.errors.fields.test_title}" placeholder="Kokeen otsikko">
		</div>
		<div class="form-group">
			<div>
				<div style="float:right;width:29%;padding:0 0.5%">
					<p>
						Kuvaa lyhyesti kokeen aihealuetta. Älä kirjoita kuvaukseen opintomateriaalia, sen syöttö on erikseen.
					</p>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit. Explicabo fugit atque in ullam, blanditiis sapiente at esse alias ipsam. Dolores nemo ducimus illum expedita unde qui ullam porro explicabo pariatur.
					</p>
				</div>
				<div style="width:70%">
					<textarea class="form-control vertical-textarea big" id="test-description"
						ng-model="data.test.description" ng-class="{'area-has-error': data.errors.fields.test_description}"
						placeholder="Kokeen kuvaus"></textarea>
				</div>
			</div>
		</div>
		
		<ul class="tabs">
			<li ng-class="{'active': activeTab == 1}"><a ng-click="setActiveTab(1)">Kysymykset</a></li>
			<li ng-class="{'active': activeTab == 2}"><a ng-click="setActiveTab(2)">Opintomateriaali</a></li>
		</ul>
		
		<div class="tab-wrapper">
			<div class="tab-panel" ng-show="activeTab == 1">
				
				<ul class="questions" ng-if="!isSorting">
					<li class="question" ng-repeat="(qkey, question) in data.test.questions" id="question-[[ qkey ]]"
						ng-class="{'active': edit_data.key == qkey, 'area-has-error': data.errors.questions[qkey] !== undefined}">
						<div class="info">
							<div class="actions">
								<button type="button" class="btn btn-primary btn-sm" ng-click="edit(qkey, question.id)">
									<span class="glyphicon glyphicon-edit"></span> Muokkaa
								</button>
								<button type="button" class="btn btn-danger btn-sm" ng-click="delete(qkey, question.id)">
									<span class="glyphicon glyphicon-trash"></span> Poista
								</button>
							</div>
							<div class="title-row clearfix">
								<div class="right-aligned">
									<div class="type">
										[[ translate_type(question.type) ]]
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
							<div class="alert-box errors" ng-show="data.errors.questions[qkey] !== undefined">
								<ul>
									<li ng-repeat="error in data.errors.questions[qkey]">[[ error ]]</li>
								</ul>
							</div>
							<div class="form-group clearfix">
								<div class="col-xs-7">
									<div class="form-group">
										<label for="">Kysymys</label>
										<input type="text" class="question-title form-control" ng-model="question.title" placeholder="Syötä kysymys">
									</div>
									<div class="form-group">
										<label for="">Kysymyksen tarkennus</label>
										<textarea class="question-subtitle form-control vertical-textarea" ng-model="question.subtitle" placeholder="Syötä tarkentava kuvaus"></textarea>
									</div>
								</div>
								<div class="col-xs-5 help-sidepanel">
									<p>
										Syötä kysymys viereiseen tekstikenttään.
									</p>
									<p>
										Voit halutessassi myös tarkentaa kysymystä alempaan kenttään, vaikka syöttämällä esimerkkejä, lisämateriaalia tai jopa kuvia. Voit käyttää normaalia HTML-merkintäkoodia kentässä.
									</p>
									<p>
										Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga placeat omnis consequuntur adipisci, eligendi architecto nobis. Doloremque vero quibusdam pariatur repudiandae, magni impedit ab totam quasi molestiae.
									</p>
								</div>
							</div>
							
							<div class="form-group question-details">
								<ul class="question-type">
									<li ng-repeat="type in question_types">
										<label ng-class="{'active': question.type == type}">
											<input type="radio" ng-model="question.type" ng-value="type" ng-click="changing_type(question, type)"> [[ translate_type(type) ]]
										</label>
									</li>
								</ul>
								<div class="question-answers">
									<div ng-show="question.type == 'MULTI'">
										<h3>Vaihtoehdot / Monivalinta usealla oikealla vastauksella</h3>
										<p>
											Käyttäjän tulee valita yksi tai useampi oikea vastaus monesta. Kysymyksellä pitää olla ainakin kaksi vaihtoehtoa.
										</p>
										<div class="form-group answer" ng-repeat="(akey, answer) in question.answers">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">[[ akey + 1 ]].</label>
											<div class="col answer-text">
												<input type="text" class="form-control" id="question-[[ qkey ]]-answer-[[ akey ]]" ng-model="answer.text" placeholder="Vaihtoehdon teksti">
											</div>
											<div class="col answer-is-correct">
												<div class="checkbox">
													<label>
														<input type="checkbox" ng-model="answer.is_correct"> Oikea vaihtoehto
													</label>
												</div>
											</div>
											<div class="col answer-delete" ng-hide="question.answers.length <= 2">
												<a class="cursor-pointer" ng-click="remove_answer(qkey, akey)">
													<span class="glyphicon glyphicon-remove"></span> Poista
												</a>
											</div>
										</div>
										<div class="form-group answer">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">Lisää uusi</label>
											<div class="col answer-text">
												<input type="text" class="form-control" ng-enter="add_answer.do(qkey, question.id)" ng-model="add_answer.text" placeholder="Syötä uusi vaihtoehto">
											</div>
											<div class="help-block" ng-show="add_answer.text != ''">
												Paina Enter varmistaaksesi lisäys
											</div>
										</div>
									</div>
									<!-- ================================================================== -->
									<div ng-show="question.type == 'CHOICE'">
										<h3>Vaihtoehdot / Monivalinta yhdellä oikealla vastauksella</h3>
										<p>
											Käyttäjän tulee valita yksi oikea vastaus monesta. Kysymyksellä pitää olla ainakin kaksi vaihtoehtoa.
										</p>
										<div class="form-group answer" ng-repeat="(akey, answer) in question.answers">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">[[ akey + 1 ]].</label>
											<div class="col answer-text">
												<input type="text" class="form-control" id="question-[[ qkey ]]-answer-[[ akey ]]" ng-model="answer.text" placeholder="Vaihtoehdon teksti">
											</div>
											<div class="col answer-is-correct">
												<div class="radio">
													<label>
														<input type="radio" ng-model="question.correct_answer" value="[[ akey ]]"> Oikea vaihtoehto
													</label>
												</div>
											</div>
											<div class="col answer-delete" ng-hide="question.answers.length <= 2">
												<a class="cursor-pointer" ng-click="remove_answer(qkey, akey)">
													<span class="glyphicon glyphicon-remove"></span> Poista
												</a>
											</div>
										</div>
										<div class="form-group answer">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">Lisää uusi</label>
											<div class="col answer-text">
												<input type="text" class="form-control" ng-enter="add_answer.do(qkey, question.id)" ng-model="add_answer.text" placeholder="Syötä uusi vaihtoehto">
											</div>
											<div class="help-block" ng-show="add_answer.text != ''">
												Paina Enter varmistaaksesi lisäys
											</div>
										</div>
									</div>
									<!-- ================================================================== -->
									<div ng-show="question.type == 'MULTITEXT'">
										<h3>Vastaukset / Moniteksti</h3>
										<p>
											Käyttäjän tulee syöttää vastaukseksi kaikki alla olevat sanat tai lauseet. Kysymyksellä pitää olla ainakin kaksi vastausta.
										</p>

										<div class="form-group answer" ng-repeat="(akey, answer) in question.answers">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">[[ akey + 1 ]].</label>
											<div class="col answer-text">
												<input type="text" class="form-control" id="question-[[ qkey ]]-answer-[[ akey ]]" ng-model="answer.text" placeholder="Vastaus">
											</div>
											<div class="col answer-delete" ng-hide="question.answers.length <= 2">
												<a class="cursor-pointer" ng-click="remove_answer(qkey, akey)">
													<span class="glyphicon glyphicon-remove"></span> Poista
												</a>
											</div>
										</div>
										<div class="form-group answer">
											<label for="question-[[ qkey ]]-answer-[[ akey ]]" class="answer-label">Lisää uusi</label>
											<div class="col answer-text">
												<input type="text" class="form-control" ng-enter="add_answer.do(qkey, question.id)" ng-model="add_answer.text" placeholder="Kirjoita sana tai lause">
											</div>
											<div class="help-block" ng-show="add_answer.text != ''">
												Paina Enter varmistaaksesi lisäys
											</div>
										</div>
									</div>
									<!-- ================================================================== -->
									<div ng-show="question.type == 'TEXT'">
										<h3>Vastaukset / Teksti</h3>
										<p>
											Käyttäjän tulee syöttää vastaukseksi alla oleva sana tai lause.
										</p>
										<div class="form-group answer">
											<div class="col answer-text wide">
												<input type="text" class="form-control" ng-model="question.answers[0].text" placeholder="Vastaus">
											</div>
										</div>
									</div>
									<!-- ================================================================== -->
									<div ng-show="question.type == 'TEXTAREA'">
										<h3>Vastaukset / Pitkä teksti</h3>
										<p>
											Käyttäjän tulee syöttää vastaukseksi jotain tekstikenttään ja vastauksen voi tarkistaa myöhemmin ylläpitopaneelista.
										</p>
										<div class="form-group answer">
											<div class="col answer-text wide">
												<textarea class="form-control" placeholder="Käyttäjä täyttää" style="resize:none" class="disabled" disabled></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="pull-right">
								<button type="button" class="btn btn-danger" ng-click="delete(qkey, question.id)">
									<span class="glyphicon glyphicon-trash"></span> Poista
								</button>
								<div style="display:inline-block;width:0.5em;"></div>
								<button type="button" class="btn btn-default" ng-click="cancel()">
									Peruuta
								</button>
								<button type="button" class="btn btn-success" ng-click="accept(qkey)">
									<span class="glyphicon glyphicon-ok"></span>&nbsp;&nbsp;Valmis
								</button>
							</div>
							<div class="clearfix"></div>
						</div>
					</li>
					<li class="add-questions" ng-class="{'has-questions':data.test.questions.length > 0, 'area-has-error': data.errors.fields.add_questions}">
						<h4 ng-show="data.test.questions.length == 0">Aloita lisäämällä kysymys</h4>
						<button type="button" class="btn btn-success" ng-click="add_question()">
							<span class="glyphicon glyphicon-plus"></span> Lisää uusi kysymys
						</button>
					</li>
				</ul>
				
				<div ng-if="isSorting">
					<ul class="questions sortable-questions" ui-sortable="sortableOptions" ng-model="data.test.questions">
						<li class="question" ng-repeat="(qkey, question) in data.test.questions" id="question-sortable-[[ qkey ]]">
							<div class="info">
								<div class="title-row clearfix">
									<div class="right-aligned">
										<div class="type">
											[[ translate_type(question.type) ]]
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
						</li>
					</ul>
					<button type="button" class="btn btn-primary btn-block" ng-click="stopSorting()">
						<span class="glyphicon glyphicon-ok"></span> Tallenna järjestys
					</button>
				</div>
			</div>
			
			<div class="tab-panel" ng-show="activeTab == 2">
				<p>
					Opintomateriaali näytetään käyttäjälle ennen kokeen suoritusta.
				</p>
				<div class="form-group ckeditor">
					<textarea ckeditor="editor_options" ng-model="data.test.page.body"></textarea>
				</div>
			</div>
		</div>
		
		<hr>
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
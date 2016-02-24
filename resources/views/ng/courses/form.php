<form ng-submit="submit(data)" ng-show="loaded">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/courses/" class="btn btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Palaa kursseihin
				</a>
			</div>
			
			<div class="form-group">
				<label>Kurssin julkisuus</label>
				<div class="radio" ng-class="{'active': data.course.published == 0}">
					<label>
						<input type="radio" ng-model="data.course.published" value="0"> Tallenna luonnoksena
					</label>
				</div>
				<div class="radio" ng-class="{'active': data.course.published == 1}">
					<label>
						<input type="radio" ng-model="data.course.published" value="1"> Julkaise
					</label>
				</div>
				<div class="help">
					Voit tallentaa kurssin luonnoksena jolloin käyttäjät eivät voi vielä suorittaa sitä. Hyvä vaihtoehto silloin kun kurssin kokeita ollaan vielä rakentamassa.
				</div>
			</div>
			<hr>
			<div class="form-group">
				<div ng-hide="processing">
					<button type="submit" class="btn btn-primary btn-block btn-lg">
						<span class="glyphicon glyphicon-floppy-disk"></span> Tallenna
					</button>
				</div>
				<div ng-show="processing" style="text-align: center">
					<img src="/img/ajax-loader.gif" alt="">
				</div>
			</div>
		</div>
		
		<div class="sidebar-help">
			<p>
				Kurssit ovat kokonaisuus kokeita järjestetyssä sarjassa. Kurssin suorittaja voi edetä kurssilla vastaamalla oikein ainakin 50% kysymyksistä kokeessa.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			<span ng-show="!id">Uusi kurssi</span>
			<span ng-show="id">Muokataan kurssia</span>
			<span ng-show="data.course.title">/ <b>[[ data.course.title ]]</b></span>
		</h1>
		<div class="alert-box success" ng-show="save_success">
			<h4><span class="glyphicon glyphicon-ok"></span> Muutokset tallennettu!</h4>
		</div>
		<div class="alert-box errors" ng-show="data.errors.messages.length > 0">
			<img src="/img/ajax-loader-error.gif" alt="" class="pull-right" ng-show="processing" style="height:40px">
			<b>Tallennus epäonnistui!</b>
			<ul>
				<li ng-repeat="error in data.errors.messages">[[ error ]]</li>
			</ul>
		</div>
		<div class="form-group">
			<label class="control-label">Kurssin otsikko</label>
			<input type="text" class="form-control input-lg input-block" id="course-title"
				ng-model="data.course.title" ng-class="{'area-has-error': data.errors.fields.course_title}" placeholder="Kurssin otsikko">
		</div>
		<div class="form-group">
			<label class="control-label">Kurssin kuvaus</label>
			<textarea class="form-control vertical-textarea big" id="course-description"
				ng-model="data.course.description" ng-class="{'area-has-error': data.errors.fields.course_description}" placeholder="Kurssin kuvaus"></textarea>
		</div>
		<hr>
		<div ng-if="!id">
			<h3>Kurssin kokeet</h3>
			<p>
				Kurssin luonnin jälkeen edetään automaattisesti kurssin ensimmäisen kokeen lisäykseen.
			</p>
		</div>
		<div class="test-sorting" ng-if="id && data.course.tests.length > 0">
			<h3>Järjestä kokeet</h3>
			<p>
				Voit uudelleenjärjestää kokeita kurssilla haluaamaasi järjestykseen.
			</p>
			<ul class="questions sortable-questions" ui-sortable="sortableOptions" ng-model="data.course.tests">
				<li class="question" ng-repeat="(key, test) in data.course.tests" id="question-sortable-[[ key ]]">
					<div class="info">
						<div class="title-row clearfix">
							<div class="left-aligned">
								<div class="number">[[ (key + 1) ]].</div>
								<div class="title" ng-class="{'no-subtitle': test.description.trim().length == 0}">
									[[ test.title ]]
								</div>
								<div class="subtitle">
									[[ test.description.split('\n')[0] ]]
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</form>

<div class="load-placeholder" ng-show="!loaded">
	<h3>
		<img src="/img/ajax-loader.gif" alt=""> Ladataan...
	</h3>
</div>
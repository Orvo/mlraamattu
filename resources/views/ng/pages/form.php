<form ng-submit="submit(data)" ng-show="loaded">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/pages/" class="btn btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Palaa sisältösivuihin
				</a>
			</div>
			
			<div class="form-group">
				<label>Navigaatio</label>
				<div ng-if="id != 1">
					<div class="radio" ng-class="{'active': data.page.pinned == 0}">
						<label>
							<input type="radio" ng-model="data.page.pinned" value="0" ng-disabled="id == 1"> Älä näytä navigaatiossa
						</label>
					</div>
					<div class="radio" ng-class="{'active': data.page.pinned == 1}">
						<label>
							<input type="radio" ng-model="data.page.pinned" value="1" ng-disabled="id == 1"> Näytä navigaatiossa
						</label>
					</div>
					<div class="help">
						Voit kiinnittää sivun näkyville navigaatioon.
					</div>
				</div>
				<div ng-if="id == 1">
					Etusivu on aina näkyvillä navigaatiossa.
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
				Sisältösivuille voi lisätä muuta sivustoa tukevaa materiaalia.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			<span ng-show="!id">Uusi sivu</span>
			<span ng-show="id">Muokataan sivua</span>
			<span ng-show="data.page.title">/ <b>[[ data.page.title ]]</b></span>
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
			<label class="control-label">Sivun otsikko</label>
			<input type="text" class="form-control input-lg input-block" id="page-title"
				ng-model="data.page.title" placeholder="Sivun otsikko" ng-disabled="id == 1">
			<p class="help-block" ng-if="id == 1">
				Etusivun otsikkoa ei voi muuttaa.
			</p>
		</div>
		
		<div class="form-group">
			<label for="page-tag" class="control-label">Sivun viite</label>
			<input type="text" class="form-control input-block" id="page-tag" ng-model="data.page.tag" ng-disabled="id == 1">
			<p class="help-block">
				Tätä viitettä käytetään sivuun linkittämisessä. Älä muokkaa jos et tiedä mitä teet.
				Olemassaolevan viitteen muokkaaminen voi hajottaa linkit.
			</p>
		</div>
		
		<div class="form-group">
			<label class="control-label">Sivun sisältö</label>
			<textarea class="form-control vertical-textarea big" id="page-body"
				ng-model="data.page.body" placeholder="Sivun kuvaus" ckeditor="editor_options"></textarea>
		</div>
		
	</div>
</form>

<div class="load-placeholder" ng-show="!loaded">
	<h3>
		<img src="/img/ajax-loader.gif" alt=""> Ladataan...
	</h3>
</div>

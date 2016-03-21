<form ng-submit="submit(data)" ng-show="loaded" class="form-horizontal">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/archive/" class="btn btn-default btn-block">
					<span class="glyphicon glyphicon-chevron-left"></span> Peruuta
				</a>
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
			<h3>Ohjeet</h3>
			<p>
				Voit luoda ryhmiä joihin muut käyttäjät voivat liittyä. Ryhmään liittyneiden käyttäjien koesuoritukset näkyvät ryhmän opettajalle ja tämä voi tarkistaa ne.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			<span ng-show="!id">Uusi ryhmä</span>
			<span ng-show="id">Muokataan ryhmä</span>
			<span ng-show="data.group.name">/ <b>[[ data.user.name ]]</b></span>
		</h1>
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
		<div>
			<fieldset>
				<legend>Perustiedot</legend>
				<div class="form-group">
					<label for="group-title" class="control-label col-xs-3">
						Ryhmän nimi
					</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="group-title" ng-model="data.group.title" placeholder="Ryhmän nimi">
					</div>
				</div>
				<div class="form-group">
					<label for="group-teacher" class="control-label col-xs-3">
						Ryhmän opettaja
					</label>
					<div class="col-xs-6">
						<select class="form-control" ng-model="group_teacher"
							ng-change="group_teacher_change()"
							ng-disabled="userData.user.access_level != 'ADMIN'"
							ng-options="user as user.name for user in users track by user.id">
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="group-code" class="control-label col-xs-3">
						Ryhmän liittymiskoodi
					</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="group-code" ng-model="data.group.code" placeholder="Liittymiskoodi">
						<p class="help-block">
							Käyttäjät liittyvät ryhmään syöttämällä tämän koodin sivustolla. Koodi voi olla mitä tahansa: sana, lause tai jotain muuta.
						</p>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Ryhmän jäsenet</legend>
				<p>
					Voit lisätä ryhmään jäseniä.
				</p>
			</fieldset>
		</div>
	</div>
</form>

<div class="load-placeholder" ng-show="!loaded">
	<h3>
		<img src="/img/ajax-loader.gif" alt=""> Ladataan...
	</h3>
</div>

<div class="modal" id="modal-delete-confirmation">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
				<h4 class="modal-title">Poiston varmistus</h4>
			</div>
			<div class="modal-body" style="text-align:center;font-size:120%">
				<p>
					Oletko varma, että haluat poistaa kysymyksen <b>"[[ modal_info.key + 1 ]]. [[ modal_info.question.title ]]"</b>?
				</p>
				<p>
					Tätä toimintoa ei voi peruuttaa!
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
<form ng-submit="submit(data)" ng-show="loaded" class="form-horizontal">
	<div id="content-sidebar" class="fixed">
		<div class="sidebar-actions">
			<div class="form-group">
				<a href="#/users/" class="btn btn-default btn-block">
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
			<p ng-show="userData.user.id == data.user.id">
				Muokkaa omia käyttäjätietojasi. Jätä salasanakenttä tyhjäksi jos et halua vaihtaa sitä. Voit myös kirjautua ulos aktiivisista istunnoista tällä sivulla.
			</p>
			<p ng-show="data.user.id && userData.user.id != data.user.id">
				Muokkaa toisen käyttäjätunnuksen tietoja käyttäjän puolesta. Tehdyistä muutoksista lähetetään käyttäjälle ilmoitus sähköpostiin.
			</p>
			<p ng-show="!data.user.id">
				Voit luoda käyttäjälle uuden tilin ilman, että tämän täytyy itse rekisteröityä. Tässä tapauksessa käyttäjälle lähetetään tieto luodusta tilisti sähköpostitse, jossa mainitaan myös annettu salasana. Käyttäjää rohkaistaan vaihtamaan salasanansa.
			</p>
		</div>
	</div>
	<div id="content-main">
		<h1>
			<span ng-show="!id">Uusi käyttäjä</span>
			<span ng-show="id">Muokataan käyttäjää</span>
			<span ng-show="data.user.name">/ <b>[[ data.user.name ]]</b></span>
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
					<label for="user-name" class="control-label col-xs-3">
						Käyttäjän nimi
					</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="user-name" ng-model="data.user.name" placeholder="Käyttäjän nimi">
					</div>
				</div>
				<div class="form-group">
					<label for="user-email" class="control-label col-xs-3">
						Käyttäjän sähköposti
					</label>
					<div class="col-xs-6">
						<input type="text" class="form-control" id="user-email" ng-model="data.user.email" placeholder="Käyttäjän sähköposti">
					</div>
				</div>
				<div class="form-group">
					<label for="user-access_level" class="control-label col-xs-3">
						Käyttäjän oikeudet
					</label>
					<div class="col-xs-6">
						<select class="form-control" ng-model="access_level"
							ng-change="access_level_change()"
							ng-disabled="userData.user.id == data.user.id"
							ng-options="level as level.description for level in access_levels track by level.level">
						</select>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Salasana</legend>
				<div class="form-group">
					<p class="col-xs-offset-3" ng-if="id">
						Jos tarpeen, voit vaihtaa tunnuksen salasanan syöttämällä uuden salasanan alle. Jätä kentät tyhjiksi jos et halua vaihtaa salasanaa.
					</p>
					<p class="col-xs-offset-3" ng-if="!id">
						Syötä käyttäjätilille salasana. Salasanan tulee olla vähintään 8 merkkiä pitkä.
					</p>
				</div>
				<div class="form-group">
					<label for="user-password" class="control-label col-xs-3">
						Salasana
					</label>
					<div class="col-xs-6">
						<input type="password" class="form-control" id="user-password" ng-model="data.user.password" placeholder="Salasana">
					</div>
				</div>
				<div class="form-group">
					<label for="user-password_confirmation" class="control-label col-xs-3">
						Salasana uudestaan
					</label>
					<div class="col-xs-6">
						<input type="password" class="form-control" id="user-password_confirmation" ng-model="data.user.password_confirmation" placeholder="Salasana uudestaan">
					</div>
				</div>
			</fieldset>
			<fieldset ng-if="id && id == userData.user.id">
				<legend>Aktiiviset istunnot</legend>
				<div>
					<p>
						Alla on listattu kaikki aktiiviset istunnot tälle käyttäjätilille. Voit kirjautua ulos istunnoista jos haluat.
					</p>
					<div class="form-group col-xs-12">
						<table class="table table-hover">
							<thead>
								<tr>
									<td></td>
									<td>IP-osoite</td>
									<td>Selain</td>
									<td>Viimeksi aktiivinen</td>
									<td>Toiminnot</td>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="session in data.user.sessions | orderBy : '-last_active'">
									<td></td>
									<td>
										[[ session.ip ]]
									</td>
									<td>
										[[ session.useragent ]]
									</td>
									<td>
										[[ session.last_active | convertToDate | date : "dd.MM.yyyy 'klo' HH:mm" ]]
									</td>
									<td>
										<div ng-if="!session.processing">
											<span class="label label-success" ng-if="data.user.currentSessionHash == session.hash">
												Tämänhetkinen istunto
											</span>
											<span class="label label-danger" ng-if="session.terminated">
												Istunto päätetty
											</span>
											<button type="button" class="btn btn-primary" ng-if="data.user.currentSessionHash != session.hash && !session.terminated" ng-click="logoutSession(session)">
												Kirjaa ulos <span class="glyphicon glyphicon-log-out"></span>
											</button>
										</div>
										<img src="/img/ajax-loader.gif" alt="" ng-if="session.processing" style="width:32px">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
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
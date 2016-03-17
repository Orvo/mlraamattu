<form ng-submit="do_login()" ng-controller="AjaxLogin" class="form-horizontal">
	<div class="modal fade" id="modal-login">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">
						<span class="glyphicon glyphicon-lock"></span> Kirjaudu sisään
					</h4>
				</div>
				<div class="modal-body" style="text-align:center;font-size:120%">
					<p>
						Istuntosi on päättynyt ja jatkaaksesi sinun tulee kirjautua sisään.
					</p>
					<div class="body-content">
						<div class="fields clearfix">
							<div class="form-group">
								<div class="col-xs-12">
									<input type="text" class="form-control input-lg" ng-model="email" placeholder="Sähköposti">
								</div>
							</div>
							<div class="form-group">
								<div class="col-xs-12">
									<input type="password" class="form-control input-lg" ng-model="password" placeholder="Salasana">
								</div>
							</div>
						</div>
						<div class="alert-box errors" ng-show="errors.length > 0">
							<ul>
								<li ng-repeat="error in errors">[[ error ]]</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-xs-4" style="text-align: left">
						<a href="[[ redirectURL || '/auth/login' ]]" class="btn" ng-class="{'btn-danger': unsavedData, 'btn-warning': !unsavedData}" ng-hide="verifying">
							<span class="glyphicon glyphicon-remove"></span>
							<span ng-show="unsavedData">Hylkää muutokset</span>
							<span ng-show="!unsavedData">Poistu ylläpidosta</span>
						</a>
					</div>
					<div class="col-xs-4">
						<div class="checkbox" ng-hide="verifying" ng-hide="verifying">
							<label>
								<input type="checkbox" ng-model="remember_me"> Muista kirjautuminen
							</label>
						</div>
					</div>
					<div class="col-xs-4">
						<button class="btn btn-primary btn-block" ng-hide="verifying">
							<span class="glyphicon glyphicon-log-in"></span> Kirjaudu sisään
						</button>
						<div ng-show="verifying">
							<img src="/img/ajax-loader.gif" alt="" style="width:30px;">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
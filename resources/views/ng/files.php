<div class="kcfinder">
	<div class="kcfinder-type">
		<div class="btn-group">
			<button type="button" ng-click="file_type = 'images'" class="btn btn-sm" ng-class="{'btn-default': file_type != 'images', 'btn-warning': file_type == 'images'}">
				<span class="glyphicon glyphicon-picture"></span> Kuvat
			</button>
			<button type="button" ng-click="file_type = 'files'" class="btn btn-sm" ng-class="{'btn-default': file_type != 'files', 'btn-warning': file_type == 'files'}">
				<span class="glyphicon glyphicon-file"></span> Tiedostot
			</button>
		</div>
	</div>
	<iframe src="/kcfinder/browse.php?type=images&amp;lang=fi" frameborder="0" ng-if="file_type == 'images'" ng-onload="kcfinderLoaded"></iframe>
	<iframe src="/kcfinder/browse.php?type=files&amp;lang=fi" frameborder="0" ng-if="file_type == 'files'" ng-onload="kcfinderLoaded"></iframe>
	[[ loaded ]]
	<div class="load-placeholder" ng-if="!loaded">
		<h3>
			<img src="/img/ajax-loader.gif" alt=""> Ladataan...
		</h3>
	</div>
</div>
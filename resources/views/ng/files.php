<div id="content-sidebar" class="fixed">
	<h3>Tiedostonhallinta</h3>
	<p>
		Tällä sivulla voit hallita palvelimelle ladattuja kuvia ja muita tiedostoja, joita voidaan hyödyntää opintomateriaalin kirjoittamisessa.
	</p>
	<p>
		Valitsemalla yläoikealta aktiivisen kategorian voit selata kuva- ja tiedostohakemistoja.
	</p>
</div>
<div id="content-main">
	<div class="kcfinder">
		<div class="kcfinder-type">
			<div class="btn-group">
				<button type="button" ng-click="setFileType('images')" class="btn btn-sm" ng-class="{'btn-default': file_type != 'images', 'btn-warning': file_type == 'images'}">
					<span class="glyphicon glyphicon-picture"></span> Kuvat
				</button>
				<button type="button" ng-click="setFileType('files')" class="btn btn-sm" ng-class="{'btn-default': file_type != 'files', 'btn-warning': file_type == 'files'}">
					<span class="glyphicon glyphicon-file"></span> Tiedostot
				</button>
			</div>
		</div>
		<iframe src="/kcfinder/browse.php?type=images&amp;lang=fi" frameborder="0" ng-if="file_type == 'images'" ng-onload="kcfinderLoaded()"></iframe>
		<iframe src="/kcfinder/browse.php?type=files&amp;lang=fi" frameborder="0" ng-if="file_type == 'files'" ng-onload="kcfinderLoaded()"></iframe>
		<div class="load-placeholder" ng-if="!loaded">
			<h3>
				<img src="/img/ajax-loader.gif" alt=""> Ladataan...
			</h3>
		</div>
	</div>
</div>
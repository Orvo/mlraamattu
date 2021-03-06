<div id="content-sidebar">
	<h2>Sivupalkki</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas eaque tempora possimus, nisi eveniet ex veritatis temporibus ratione quo eos.</p>
	<p>Doloremque porro maxime reprehenderit sequi harum reiciendis incidunt soluta rem ipsam nulla non, distinctio molestiae dolorum alias, eaque quia. Dolor, voluptates temporibus nesciunt ullam sed veritatis, ratione tenetur quo, ipsum minima consectetur est quam obcaecati cumque, porro.</p>
</div>
<div id="content-main">
	<h1>Kokeet</h1>
	<div class="alert-box warning" ng-show="routeError == 404">
		<h4><span class="glyphicon glyphicon-alert"></span> Haettua koetta ei löytynyt!</h4>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<td style="width:40px;"></td>
				<td style="width:250px">Kokeen otsikko</td>
				<td>Kurssi</td>
				<td style="width:25%">Kuvaus</td>
				<td>Kysymykset</td>
				<td style="width:12%;min-width:130px">Toiminnot</td>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="(key, test) in tests">
				<td style="font-weight: bold;text-align: right;background:#fafafa">[[ key + 1 ]].</td>
				<td>
					<a href="#/tests/[[ test.course.id ]]">
						[[ test.title ]]
					</a>
				</td>
				<td>
					<a href="#/courses/[[ test.course.id ]]">
						[[ test.course.title ]]
					</a>
				</td>
				<td>[[ test.description ]]</td>
				<td>
					<ul>
						<li ng-repeat="question in test.questions">[[ question.title ]]</li>
					</ul>
					<span ng-show="test.questions.length == 0">Ei kysymyksiä</span>
				</td>
				<td>
					<a href="#/tests/[[ test.id ]]/edit" class="btn btn-primary btn-xs btn-block">
						<span class="glyphicon glyphicon-edit"></span> Muokkaa
					</a>
					<a href="#/tests/[[ test.id ]]/delete" class="btn btn-danger btn-xs btn-block">
						<span class="glyphicon glyphicon-trash"></span> Poista
					</a>
				</td>
			</tr>
		</tbody>
	</table>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illo vel maiores temporibus distinctio laborum asperiores odio ratione expedita reprehenderit rerum quos recusandae quae facilis necessitatibus ducimus minus exercitationem, atque dolorem omnis unde, ad, consectetur sed! Doloremque id distinctio perferendis, vel.
	</p>
</div>
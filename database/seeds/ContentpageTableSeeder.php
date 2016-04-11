<?php

use Illuminate\Database\Seeder;

use App\Contentpage;

class ContentpageTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$page = Contentpage::findOrNew(1);
		
		$page->id  		= 1;
		$page->title    = "Etusivu";
		$page->tag      = "etusivu";
		$page->body     = "<h1>Etusivu</h1><p>  Tervetuloa etusivulle. Tämä on oletusetusivu jota voit muokata ylläpitopaneelissa.</p><p>   Lorem ipsum dolor sit amet, consectetur adipisicing elit. Delectus sunt, quam. Commodi in est eum mollitia incidunt maiores cumque. Laboriosam quisquam facere ut fugiat est ad laborum cumque, accusamus quasi perferendis. Quam dicta, sunt, similique beatae earum excepturi error quasi quos velit iste accusamus temporibus? Iste earum necessitatibus pariatur excepturi at recusandae consectetur quasi.</p><h2>Hello World</h2><p>  Error, quia suscipit architecto expedita obcaecati nisi pariatur recusandae odit vel animi neque voluptatibus deserunt, quidem voluptatem totam facilis a quae rerum hic, reiciendis dolore? Nemo optio corporis tempora, excepturi doloremque, voluptatum quae fugiat cupiditate iure amet, facilis, earum eligendi libero voluptatem illo. Voluptas at alias delectus nulla adipisci quasi cupiditate ipsa eligendi recusandae.</p>";
		
		$page->save();
	}
}

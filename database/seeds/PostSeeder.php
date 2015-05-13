<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		$discussions = DiscussionSeeder::$number;
		$posts = $discussions * 10;

		for ($d = 1; $d <= $discussions; $d++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, User::count()),
				'discussion_id' => $d,
				'content' => $faker->realText(750),
			]);
		}

		for ($p = 0; $p < $posts; $p++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, User::count()),
				'discussion_id' => $faker->numberBetween(1, $discussions),
				'content' => $faker->realText(750),
			]);
		}
	}

}
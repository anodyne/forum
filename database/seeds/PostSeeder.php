<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {

	public static $number = 500;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		for ($d = 1; $d <= DiscussionSeeder::$number; $d++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, 2),
				'discussion_id' => $d,
				'content' => $faker->realText(750),
			]);
		}

		for ($i = 0; $i < static::$number; $i++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, 2),
				'discussion_id' => $faker->numberBetween(1, DiscussionSeeder::$number),
				'content' => $faker->realText(750),
			]);
		}
	}

}
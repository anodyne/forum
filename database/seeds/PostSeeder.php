<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {

	public static $number = 100;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		for ($c = 1; $c <= ConversationSeeder::$number; $c++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, 2),
				'conversation_id' => $c,
				'content' => $faker->realText(750),
			]);
		}

		for ($i = 0; $i < static::$number; $i++)
		{
			Post::create([
				'user_id' => $faker->numberBetween(1, 2),
				'conversation_id' => $faker->numberBetween(1, ConversationSeeder::$number),
				'content' => $faker->realText(750),
			]);
		}
	}

}
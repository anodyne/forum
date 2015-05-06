<?php

use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder {

	public static $number = 25;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 0; $i < static::$number; $i++)
		{
			Conversation::create([
				'user_id' => $faker->numberBetween(1, 2),
				'topic_id' => $faker->numberBetween(1, 3),
				'title' => ucwords(implode(' ', $faker->words($faker->numberBetween(3, 10)))),
				'slug' => '',
			]);
		}
	}

}
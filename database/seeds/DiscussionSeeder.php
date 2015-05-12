<?php

use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder {

	public static $number = 250;

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
			$title = ucwords(implode(' ', $faker->words($faker->numberBetween(3, 10))));

			Discussion::create([
				'user_id' => $faker->numberBetween(1, 2),
				'topic_id' => $faker->numberBetween(1, 9),
				'title' => $title,
				'slug' => $this->makeSlugFromTitle($title),
			]);
		}
	}

	protected function makeSlugFromTitle($title)
	{
		// Make the slug
		$slug = Str::slug($title);

		// Are there other items with this slug?
		$count = Discussion::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

		return ($count) ? "{$slug}-{$count}" : $slug;
	}

}
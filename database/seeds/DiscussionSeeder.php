<?php

use Illuminate\Database\Seeder;

class DiscussionSeeder extends Seeder {

	public static $number = 500;

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

			$topic = $faker->numberBetween(1, Topic::count());

			Discussion::create([
				'user_id' => $faker->numberBetween(1, User::count()),
				'topic_id' => $topic,
				'title' => $title,
				'slug' => $this->makeSlugFromTitle($title, $topic),
			]);
		}
	}

	protected function makeSlugFromTitle($title, $topicId)
	{
		// Make the slug
		$slug = Str::slug($title);

		// Are there other items with this slug?
		$count = Discussion::where('topic_id', $topicId)
			->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

		return ($count) ? "{$slug}-{$count}" : $slug;
	}

}
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

		foreach (Discussion::all() as $discussion)
		{
			// Should this discussion have an answer?
			$shouldBeAnswered = $faker->boolean();

			// An array for storing all the post IDs
			$ids = [];

			for ($p = 0; $p < $faker->numberBetween(1, 25); $p++)
			{
				$post = Post::create([
					'user_id' => $faker->numberBetween(1, User::count()),
					'discussion_id' => $discussion->id,
					'content' => $faker->realText($faker->numberBetween(100, 1000)),
				]);

				if ($shouldBeAnswered and $p > 0)
				{
					$ids[] = $post->id;
				}
			}

			if ($shouldBeAnswered and count($ids) > 0)
			{
				$key = $faker->numberBetween(0, (count($ids) - 1));

				$discussion->update(['answer_id' => $ids[$key]]);
			}

			// Reset the list
			$ids = [];
		}
	}

}
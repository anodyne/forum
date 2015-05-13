<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {

	protected $usersList = [];

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker\Factory::create();

		// Build the list of user IDs
		$this->usersList = range(1, User::count());

		foreach (Discussion::all() as $discussion)
		{
			// Should this discussion have an answer?
			$shouldBeAnswered = $faker->boolean();

			// An array for storing all the post IDs
			$ids = [];

			// Store what the last user ID was
			$lastUserId = 0;

			for ($p = 0; $p < $faker->numberBetween(1, 50); $p++)
			{
				// Get a user ID, but make sure it isn't the last one we used
				$userId = $this->randomNumberExcluding($lastUserId);

				$post = Post::create([
					'user_id' => $this->randomNumberExcluding($lastUserId),
					'discussion_id' => $discussion->id,
					'content' => $faker->realText($faker->numberBetween(100, 1000)),
				]);

				// Now set the last user ID
				$lastUserId = $userId;

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

	protected function randomNumberExcluding($exclude)
	{
		// Figure out the veto list
		$vetoList = [$exclude];

		// Get a list of values that we can use
		$aliveList = array_diff($this->usersList, $vetoList);

		return $aliveList[array_rand($aliveList)];
	}

}
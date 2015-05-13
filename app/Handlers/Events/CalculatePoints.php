<?php namespace Forums\Handlers\Events;

use UserRepositoryInterface;
use Forums\Events;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class CalculatePoints {

	protected $user;
	protected $points = 0;
	protected $userRepo;

	protected $pointsPosts = 1;
	protected $pointsAnswers = 100;
	protected $pointsDiscussions = 5;

	public function __construct(UserRepositoryInterface $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	public function handle($event)
	{
		// Get the user
		$this->user = $event->user;

		// Calculate points for discussions
		if ($event instanceof Events\DiscussionWasCreated)
			$this->points += $this->pointsDiscussions;

		// Calculate points for posts
		if ($event instanceof Events\PostWasCreated)
			$this->points += $this->pointsPosts;

		// Calculate points for answered posts
		if ($event instanceof Events\DiscussionWasAnswered)
			$this->points += $this->pointsAnswers;

		// Update the user
		if ($this->points > 0)
			$this->userRepo->addPoints($this->user, $this->points);
	}

}

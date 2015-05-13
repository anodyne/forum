<?php namespace Forums\Events;

use User, Discussion;
use Forums\Events\Event;
use Illuminate\Queue\SerializesModels;

class DiscussionWasCreated extends Event {

	use SerializesModels;

	public $user;
	public $discussion;

	public function __construct(Discussion $discussion, User $user)
	{
		$this->user = $user;
		$this->discussion = $discussion;
	}

}

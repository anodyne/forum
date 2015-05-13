<?php namespace Forums\Events;

use Post, User, Discussion;
use Forums\Events\Event;
use Illuminate\Queue\SerializesModels;

class PostWasCreated extends Event {

	use SerializesModels;

	public $post;
	public $user;
	public $discussion;

	public function __construct(Discussion $discussion, Post $post, User $user)
	{
		$this->post = $post;
		$this->user = $user;
		$this->discussion = $discussion;
	}

}

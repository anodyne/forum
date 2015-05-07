<?php namespace Forums\Data\Interfaces;

use User, Discussion, DiscussionState;

interface DiscussionStateRepositoryInterface extends BaseRepositoryInterface {

	public function getStateForCurrentUser(User $user, Discussion $discussion);
	public function updateState(DiscussionState $state);

}

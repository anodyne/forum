<?php namespace App\Data\Repositories;

use Date,
	User,
	Discussion,
	DiscussionState as Model,
	DiscussionStateRepositoryInterface;

class DiscussionStateRepository extends BaseRepository implements DiscussionStateRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getStateForCurrentUser(User $user, Discussion $discussion)
	{
		$discussionState = $this->model->firstOrNew([
			'user_id'		=> $user->id,
			'discussion_id'	=> $discussion->id,
		]);

		$discussionState->save();

		return $discussionState;
	}

	public function updateState(Model $model)
	{
		return $model->update(['last_visited' => Date::now()]);
	}

}

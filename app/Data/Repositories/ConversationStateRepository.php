<?php namespace Forums\Data\Repositories;

use Date,
	User,
	Conversation,
	ConversationState as Model,
	ConversationStateRepositoryInterface;

class ConversationStateRepository extends BaseRepository implements ConversationStateRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getStateForCurrentUser(User $user, Conversation $conversation)
	{
		return $this->model->firstOrNew([
			'user_id'			=> $user->id,
			'conversation_id'	=> $conversation->id,
		]);
	}

	public function updateState(Model $model)
	{
		$model->update(['last_visited' => Date::now()]);
	}

}

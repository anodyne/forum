<?php namespace Forums\Data\Repositories;

use Conversation as Model,
	ConversationRepositoryInterface;

class ConversationRepository extends BaseRepository implements ConversationRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getConversation($topicSlug, $slug)
	{
		//
	}

}

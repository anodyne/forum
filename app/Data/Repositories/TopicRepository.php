<?php namespace Forums\Data\Repositories;

use Topic as Model,
	TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all(array $with = [])
	{
		$query = (count($with) == 0)
			? $this->make(['conversations', 'conversations.posts', 'conversations.posts.author'])
			: $this->make($with);

		return $query->get();
	}

}

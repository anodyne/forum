<?php namespace Forums\Data\Repositories;

use Topic as Model,
	TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

<?php namespace Forums\Data\Repositories;

use Discussion as Model,
	DiscussionRepositoryInterface;

class DiscussionRepository extends BaseRepository implements DiscussionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function getDiscussion($topicSlug, $slug)
	{
		//
	}

}

<?php namespace Forums\Data\Repositories;

use Post as Model,
	PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}

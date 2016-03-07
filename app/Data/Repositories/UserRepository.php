<?php namespace App\Data\Repositories;

use User as Model,
	UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function addPoints(Model $model, $points)
	{
		$model->increment('points', $points);
	}

}

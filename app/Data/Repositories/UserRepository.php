<?php namespace Forums\Data\Repositories;

use User as Model,
	UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function addPoints(User $user, $points)
	{
		$user->increment('points', $points);
	}

}

<?php namespace Forums\Data\Interfaces;

use User;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function addPoints(User $user, $points);

}

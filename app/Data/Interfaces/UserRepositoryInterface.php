<?php namespace Forums\Data\Interfaces;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function addPoints(User $user, $points);

}

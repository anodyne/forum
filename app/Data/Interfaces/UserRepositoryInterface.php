<?php namespace App\Data\Interfaces;

use User;

interface UserRepositoryInterface extends BaseRepositoryInterface {

	public function addPoints(User $user, $points);

}

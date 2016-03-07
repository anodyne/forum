<?php namespace App\Data;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	protected $connection = 'users';
	
}

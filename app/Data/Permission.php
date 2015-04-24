<?php namespace Forums\Data;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	protected $connection = 'users';
	
}

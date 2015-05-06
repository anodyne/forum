<?php namespace Forums\Data;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole {

	protected $connection = 'users';
	
}

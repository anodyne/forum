<?php namespace Forums\Http\Controllers;

use UserRepositoryInterface;
use Forums\Http\Requests;
use Illuminate\Http\Request;

class UserController extends Controller {

	protected $repo;

	public function __construct(UserRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function discussions($username = false)
	{
		# code...
	}

	public function show($username)
	{
		//
	}

}

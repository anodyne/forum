<?php namespace Forums\Http\Controllers;

use Log,
	Auth,
	Response;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected $currentUser;
	protected $request;

	public function __construct()
	{
		$this->currentUser = (app('auth')->check())
			? app('auth')->user()->load('roles', 'roles.perms')
			: null;
		$this->request = app('request')->instance();

		// Make sure we some variables available on all views
		view()->share('_currentUser', $this->currentUser);
		view()->share('_icons', config('icons'));
	}

	protected function errorUnauthorized($message = false)
	{
		Log::error("{$this->currentUser->name} attempted to access {$this->request->fullUrl()}");

		if ($message)
		{
			return view('pages.error')->withError($message)->withType('danger');
		}
	}

	protected function errorNotFound($message = false)
	{
		Log::error("A user attempted to reach {$this->request->fullUrl()}");

		if ($message)
		{
			return view('pages.error')->withError($message)->withType('danger');
		}
	}

}

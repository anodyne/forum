<?php namespace Forums\Http\Controllers;

use Conversation;
use Forums\Http\Requests,
	Forums\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller {

	protected $repo;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$conversations = Conversation::with('posts', 'topic')->get();

		return view('pages.main', compact('conversations'));
	}

}

<?php namespace Forums\Http\Controllers;

use TopicRepositoryInterface,
	DiscussionRepositoryInterface;
use Forums\Http\Requests,
	Forums\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller {

	protected $repo;

	public function __construct(DiscussionRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function index(TopicRepositoryInterface $topicsRepo, Request $request)
	{
		// Get all the parent topics for the sidebar
		$topics = $topicsRepo->allParents();

		// Get the paginated discussions
		$paginator = $this->repo->paginateAll($request->get('page', 1), 25);
		$paginator->setPath($request->getPathInfo());

		return view('pages.main', compact('paginator', 'topics'));
	}

}

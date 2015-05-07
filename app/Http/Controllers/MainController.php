<?php namespace Forums\Http\Controllers;

use Topic,
	Discussion,
	TopicRepositoryInterface,
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

	public function index(TopicRepositoryInterface $topicsRepo)
	{
		// Get all the parent topics for the sidebar
		$topics = $topicsRepo->allParents();

		$discussions = Discussion::with('posts', 'posts.author', 'topic', 'topic.parent', 'author')
			->orderBy('updated_at', 'desc')
			->get();

		return view('pages.main', compact('discussions', 'topics'));
	}

}

<?php namespace App\Http\Controllers;

use TopicRepositoryInterface;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TopicController extends Controller {

	protected $repo;

	public function __construct(TopicRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function index()
	{
		// Get all the parent topics
		$topics = $this->repo->allParents(['discussions', 'discussions.posts', 'discussions.posts.author', 'children', 'children.discussions', 'children.discussions.posts', 'children.discussions.posts.author', 'children.parent']);

		return view('pages.topics.all', compact('topics'));
	}

	public function show(Request $request, $slug)
	{
		// Get the topic
		$topic = $this->repo->getBySlug($slug);

		if ($topic)
		{
			// Grab the parent topic
			$parent = $this->repo->getParentTopic($topic);

			// Grab any children topics
			$children = $this->repo->getChildrenTopics($topic);

			// Pull the discussinos out of the topic and paginate for the page
			$paginator = $this->repo->paginateDiscussions($topic, $request->get('page', 1), 25);

			// Set the URL for the paginator
			$paginator->setPath($request->getPathInfo());

			return view('pages.topics.show', compact('topic', 'paginator', 'children', 'parent'));
		}

		return $this->errorNotFound("No such topic exists!");
	}

}

<?php namespace Forums\Http\Controllers;

use TopicRepositoryInterface;
use Forums\Http\Requests;
use Illuminate\Http\Request;

class TopicController extends Controller {

	protected $repo;

	public function __construct(TopicRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function index()
	{
		// Get all the parent topics for the sidebar
		$allTopics = $this->repo->allParents();

		// Get all the topics
		$topics = $this->repo->all();

		return view('pages.topics.all', compact('topics', 'allTopics'));
	}

	public function show($slug)
	{
		// Get the topic
		$topic = $this->repo->getTopicBySlug($slug);

		if ($topic)
		{
			// Grab the parent topic
			$parent = $this->repo->getParentTopic($topic);

			// Grab any children topics
			$children = $this->repo->getChildrenTopics($topic);

			// Pull the discussions out of the topic
			$discussions = $this->repo->getDiscussions($topic);

			return view('pages.topics.show', compact('topic', 'discussions', 'children', 'parent'));
		}

		return $this->errorNotFound("No such topic exists!");
	}

}

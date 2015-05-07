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
		// Get all the topics
		$topics = $this->repo->all();

		return view('pages.topics.all', compact('topics'));
	}

	public function show($slug)
	{
		// Get the topic
		$topic = $this->repo->getFirstBy($topic, $slug);

		if ($topic)
		{
			$conversations = [];

			return view('pages.topics.show', compact('topic', 'conversations'));
		}

		return $this->errorNotFound("No such topic exists!");
	}

}

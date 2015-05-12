<?php namespace Forums\Http\Controllers;

use TopicRepositoryInterface,
	DiscussionRepositoryInterface,
	DiscussionStateRepositoryInterface;
use Forums\Events,
	Forums\Http\Requests;
use Illuminate\Http\Request;

class DiscussionController extends Controller {

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

		return view('pages.discussions.all', compact('paginator', 'topics'));
	}

	public function show(DiscussionStateRepositoryInterface $stateRepo, $topicSlug, $discussionSlug)
	{
		// Get the discussion
		$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

		// Get the first post
		$firstPost = $discussion->posts->first();

		// Get any right answer
		$answer = $discussion->answer;

		// Get everything except the first post
		$posts = $discussion->posts->except($firstPost->id);

		if ($this->currentUser)
		{
			// Get the state for the current user
			$state = $stateRepo->getStateForCurrentUser($this->currentUser, $discussion);

			// Update the state for the current user
			$stateRepo->updateState($state);
		}

		return view('pages.discussions.show', compact('discussion', 'firstPost', 'posts', 'answer'));
	}

	public function create(TopicRepositoryInterface $topicsRepo)
	{
		// Get all the topics
		$topics[''] = "Pick a topic for your discussion";
		$topics += $topicsRepo->listAll('name', 'id');

		return view('pages.discussions.create', compact('topics'));
	}

	public function store(Requests\CreateDiscussionRequest $request)
	{
		// Create the discussion and first post
		$discussion = $this->repo->create(array_merge_recursive($request->all(), [
			'user' => $this->currentUser->id
		]));

		// Fire the event

		// Set the flash message
		flash_success("Discussion created!");

		return redirect()->route('discussion.show', [$discussion->topic->slug, $discussion->slug]);
	}

	public function storeQuickReply(Request $request, $topicSlug, $discussionSlug)
	{
		// Get the discussion
		$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

		if ($discussion)
		{
			// Create the post
			$post = $this->repo->postReply($discussion, $request->all());

			// Fire the event

			// Set the flash message

			return redirect()->route('discussion.show', [$topicSlug, $discussionSlug]);
		}

		return $this->errorNotFound("No discussion found.");
	}

}

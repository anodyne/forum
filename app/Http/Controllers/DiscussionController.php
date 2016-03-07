<?php namespace App\Http\Controllers;

use PostRepositoryInterface,
	TopicRepositoryInterface,
	DiscussionRepositoryInterface,
	DiscussionStateRepositoryInterface;
use App\Events,
	App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class DiscussionController extends Controller {

	protected $repo;
	protected $postsRepo;
	protected $topicsRepo;

	public function __construct(DiscussionRepositoryInterface $repo,
			TopicRepositoryInterface $topics, PostRepositoryInterface $posts)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->postsRepo = $posts;
		$this->topicsRepo = $topics;
	}

	public function index(Request $request)
	{
		// Get all the parent topics for the sidebar
		$topics = $this->topicsRepo->allParents();

		// What page are we on?
		$page = $request->get('page', 1);

		// How many items do we want?
		$perPage = 20;

		// Get the discussions
		$discussions = $this->repo->paginate($page, $perPage);

		// Build the paginator
		$paginator = new Paginator($discussions->items, $discussions->totalItems, $perPage, $page);
		$paginator->setPath(route('home'));

		return view('pages.discussions.all', compact('paginator', 'topics'));
	}

	public function show(DiscussionStateRepositoryInterface $stateRepo, Request $request,
			$topicSlug, $discussionSlug)
	{
		// Get the discussion
		$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

		if ($discussion)
		{
			// Get the first post of the discussion
			$firstPost = $this->repo->getFirstPost($discussion);

			// Get the right answer for the discussion
			$answer = $this->repo->getAnswer($discussion);

			// What page are we on?
			$page = $request->get('page', 1);

			// How many items do we want?
			$perPage = 15;

			// Get the posts
			$posts = $this->postsRepo->paginate($discussion, $page, $perPage);

			// Build the paginator
			$paginator = new Paginator($posts->items, $posts->totalItems, $perPage, $page);
			$paginator->setPath(route('discussion.show', [$topicSlug, $discussionSlug]));

			if ($this->currentUser)
			{
				// Get the state for the current user
				$state = $stateRepo->getStateForCurrentUser($this->currentUser, $discussion);

				// Update the state for the current user
				$stateRepo->updateState($state);
			}

			return view('pages.discussions.show', compact('discussion', 'firstPost', 'paginator', 'answer'));
		}

		return abort(404, "We couldn't find the discussion you're looking for.");

		return $this->errorNotFound("We couldn't find the discussion you're looking for.");
	}

	public function create()
	{
		if ($this->currentUser->can('forums.discussion.create'))
		{
			// Get all the topics
			$topics[''] = "Pick a topic for your discussion";
			$topics += $this->topicsRepo->listAll('name', 'id');

			return view('pages.discussions.create', compact('topics'));
		}

		return $this->errorUnauthorized("You do not have permission to create discussions.");
	}

	public function store(Requests\CreateDiscussionRequest $request)
	{
		if ($this->currentUser->can('forums.discussion.create'))
		{
			// Create the discussion and first post
			$discussion = $this->repo->create(array_merge_recursive($request->all(), [
				'user' => $this->currentUser->id
			]));

			// Fire the event
			event(new Events\DiscussionWasCreated($discussion, $this->currentUser));

			// Set the flash message
			flash_success("Your discussion has been created.");

			return redirect()->route('discussion.show', [$discussion->topic->slug, $discussion->slug]);
		}

		return $this->errorUnauthorized("You do not have permission to create discussions.");
	}

	public function storeReply(Requests\CreatePostRequest $request, $topicSlug, $discussionSlug)
	{
		if ($this->currentUser->can('forums.post.create'))
		{
			// Get the discussion
			$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

			if ($discussion)
			{
				// Create the post
				$post = $this->repo->postReply($discussion, $request->all());

				// Fire the event
				event(new Events\PostWasCreated($discussion, $post, $this->currentUser));

				// Set the flash message
				flash_success("Your reply has been posted.");

				return redirect()->route('discussion.show', [$topicSlug, $discussionSlug]);
			}

			return $this->errorNotFound("We couldn't find the discussion you're looking for.");
		}

		return $this->errorUnauthorized("You do not have permission to create discussion posts.");
	}

	public function edit(Requests\EditDiscussionRequest $request, $topicSlug, $discussionSlug)
	{
		if ($this->currentUser->can('forums.admin'))
		{
			// Get the discussion
			$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

			if ($discussion)
			{
				// Get all the topics
				$topics[''] = "Pick a topic for your discussion";
				$topics += $this->topicsRepo->listAll('name', 'id');

				return view('pages.discussions.edit', compact('topics', 'discussion'));
			}

			return $this->errorNotFound("We couldn't find the discussion you're looking for.");
		}

		return $this->errorUnauthorized("You do not have permission to edit discussions.");
	}

	public function update(Requests\UpdateDiscussionRequest $request, $topicSlug, $discussionSlug)
	{
		if ($this->currentUser->can('forums.admin'))
		{
			// Create the discussion and first post
			$discussion = $this->repo->create(array_merge_recursive($request->all(), [
				'user' => $this->currentUser->id
			]));

			// Fire the event
			event(new Events\DiscussionWasUpdated($discussion, $this->currentUser));

			// Set the flash message
			flash_success("The discussion has been updated.");

			return redirect()->route('discussion.show', [$discussion->topic->slug, $discussion->slug]);
		}

		return $this->errorUnauthorized("You do not have permission to edit discussions.");
	}

	public function remove($topicSlug, $discussionSlug)
	{
		if ($this->currentUser->can('forums.admin'))
		{
			//
		}

		return $this->errorUnauthorized("You do not have permission to remove discussions.");
	}

	public function destroy($topicSlug, $discussionSlug)
	{
		if ($this->currentUser->can('forums.admin'))
		{
			//
		}

		return $this->errorUnauthorized("You do not have permission to remove discussions.");
	}

}

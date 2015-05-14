<?php namespace Forums\Http\Controllers;

use TopicRepositoryInterface,
	DiscussionRepositoryInterface,
	DiscussionStateRepositoryInterface;
use Forums\Events,
	Forums\Http\Requests;
use Illuminate\Http\Request;

class DiscussionController extends Controller {

	protected $repo;
	protected $topicsRepo;

	public function __construct(DiscussionRepositoryInterface $repo,
			TopicRepositoryInterface $topics)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->topicsRepo = $topics;
	}

	public function index(Request $request)
	{
		// Get all the parent topics for the sidebar
		$topics = $this->topicsRepo->allParents();

		// Get the paginated discussions
		$paginator = $this->repo->paginateAll($request->get('page', 1));
		$paginator->setPath(route('home'));

		return view('pages.discussions.all', compact('paginator', 'topics'));
	}

	public function show(DiscussionStateRepositoryInterface $stateRepo,
			Request $request, $topicSlug, $discussionSlug)
	{
		// Get the discussion
		$discussion = $this->repo->getDiscussion($topicSlug, $discussionSlug);

		// Get the first post
		$firstPost = $this->repo->getFirstPost($discussion);

		// Get any right answer
		$answer = $this->repo->getAnswer($discussion);

		// Paginate the posts
		$posts = $this->repo->paginatePosts($discussion, $request->get('page', 1));
		$posts->setPath(route('discussion.show', [$topicSlug, $discussionSlug]));

		if ($this->currentUser)
		{
			// Get the state for the current user
			$state = $stateRepo->getStateForCurrentUser($this->currentUser, $discussion);

			// Update the state for the current user
			$stateRepo->updateState($state);
		}

		return view('pages.discussions.show', compact('discussion', 'firstPost', 'posts', 'answer'));
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

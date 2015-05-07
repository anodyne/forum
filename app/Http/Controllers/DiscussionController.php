<?php namespace Forums\Http\Controllers;

use DiscussionRepositoryInterface;
use Forums\Http\Requests;
use Illuminate\Http\Request;

class DiscussionController extends Controller {

	protected $repo;

	public function __construct(DiscussionRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function show(DiscussionStateRepositoryInterface $stateRepo, $topic, $slug)
	{
		// Get the discussion
		$discussion = $this->repo->getDiscussion($topic, $slug);

		if ($this->currentUser)
		{
			// Get the state for the current user
			$state = $stateRepo->getStateForCurrentUser($this->currentUser, $discussion);

			// Update the state for the current user
			$stateRepo->updateState($state);
		}

		return view('pages.discussions.show', compact('discussion'));
	}

}

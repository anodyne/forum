<?php namespace Forums\Http\Controllers;

use Forums\Http\Requests;
use Illuminate\Http\Request;

class ConversationController extends Controller {

	protected $repo;

	public function __construct(ConversationRepositoryInterface $repo)
	{
		parent::__construct();

		$this->repo = $repo;
	}

	public function show(ConversationStateRepositoryInterface $stateRepo, $topic, $slug)
	{
		// Get the conversation
		$conversation = $this->repo->getConversation($topic, $slug);

		if ($this->currentUser)
		{
			// Get the state for the current user
			$state = $stateRepo->getStateForCurrentUser($this->currentUser, $conversation);

			// Update the state for the current user
			$stateRepo->updateState($state);
		}

		return view('pages.conversations.show', compact('conversation'));
	}

}

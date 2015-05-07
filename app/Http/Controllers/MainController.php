<?php namespace Forums\Http\Controllers;

use Topic, Conversation;
use Forums\Http\Requests,
	Forums\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainController extends Controller {

	protected $repo;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$conversations = Conversation::with('posts', 'posts.author', 'topic', 'author')->get();

		return view('pages.main', compact('conversations'));
	}

	public function allTopics()
	{
		# code...
	}

	public function topic($slug)
	{
		// Get the topic
		$topic = Topic::with('conversations', 'conversations.posts', 'conversations.posts.author')
			->slug($slug)->first();

		return view('pages.topic', compact('topic'));
	}

	public function conversation($topicSlug, $conversationId)
	{
		return view('pages.conversation');
	}

}

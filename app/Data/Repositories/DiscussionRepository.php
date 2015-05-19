<?php namespace Forums\Data\Repositories;

use stdClass;
use Str,
	Discussion as Model,
	PostRepositoryInterface,
	TopicRepositoryInterface,
	DiscussionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DiscussionRepository extends BaseRepository implements DiscussionRepositoryInterface {

	protected $model;
	protected $postsRepo;

	public function __construct(Model $model, PostRepositoryInterface $postsRepo)
	{
		$this->model = $model;
		$this->postsRepo = $postsRepo;
	}

	public function create(array $data)
	{
		// Create a discussion
		$discussion = $this->model->create([
			'topic_id'	=> $data['topic'],
			'user_id'	=> $data['user'],
			'title'		=> $data['title'],
			'slug'		=> $this->makeSlugFromTitle($data['title'], $data['topic']),
		]);

		// Create the first post
		$this->postsRepo->create($discussion, $data);

		return $discussion;
	}

	public function getAnswer(Model $model)
	{
		return $model->answer;
	}

	public function getDiscussion($topicSlug, $discussionSlug)
	{
		// Get the topic
		$topic = app('TopicRepository')->getBySlug($topicSlug);

		if ($topic)
		{
			$discussion = $topic->discussions->filter(function($d) use ($discussionSlug)
			{
				return $d->slug == $discussionSlug;
			})->first();

			if ($discussion)
			{
				return $discussion->load('answer', 'posts.author', 'topic', 'topic.parent');
			}
		}

		return false;
	}

	public function getFirstPost(Model $model)
	{
		return $model->posts->first();
	}

	public function paginateAll($page = 1, $perPage = 20)
	{
		// Start building the query
		$query = $this->make(['posts', 'posts.author', 'topic', 'topic.parent', 'author', 'stateForUser', 'answer']);

		// Get the discussions
		$discussions = $query->orderBy('updated_at', 'desc')->get();

		// Build the offset
		$offset = ($page * $perPage) - $perPage;

		// Get the items for the current page
		$itemsForCurrentPage = $discussions->slice($offset, $perPage);

		return new LengthAwarePaginator($itemsForCurrentPage, $discussions->count(), $perPage, $page);
	}

	public function paginate($page = 1, $perPage = 20)
	{
		// Start building the result set
		$result = new stdClass;
		$result->page = $page;
		$result->perPage = $perPage;
		$result->totalItems = 0;
		$result->items = [];

		// Build the offset
		$offset = $perPage * ($page - 1);

		// Build the query
		$query = $this->make(['posts', 'posts.author', 'topic', 'topic.parent', 'author', 'stateForUser', 'answer'])->skip($offset)->take($perPage)->orderBy('updated_at', 'desc');

		// Execute the query
		$model = $query->get();

		// Fill in the result set
		$result->totalItems = $this->count();
		$result->items = $model->all();

		return $result;
	}

	protected function makeSlugFromTitle($title, $topicId)
	{
		// Make the slug
		$slug = Str::slug($title);

		// Are there other items with this slug?
		$count = Model::where('topic_id', $topicId)
			->whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

		return ($count) ? "{$slug}-{$count}" : $slug;
	}

}

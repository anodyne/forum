<?php namespace Forums\Data\Repositories;

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

	public function getDiscussion($topicSlug, $discussionSlug)
	{
		// Get the topic
		$topic = app('TopicRepository')->getBySlug($topicSlug);

		if ($topic)
		{
			return $topic->discussions->filter(function($d) use ($discussionSlug)
			{
				return $d->slug == $discussionSlug;
			})->first()->load('answer', 'posts.author');
		}

		return false;
	}

	public function paginateAll($page = 1, $perPage = 25)
	{
		// Start building the query
		$query = $this->make(['posts', 'posts.author', 'topic', 'topic.parent', 'author', 'stateForUser']);

		// Get the discussions
		$discussions = $query->orderBy('updated_at', 'desc')->get();

		// Build the offset
		$offset = ($page * $perPage) - $perPage;

		// Get the items for the current page
		$itemsForCurrentPage = $discussions->slice($offset, $perPage);

		return new LengthAwarePaginator($itemsForCurrentPage, $discussions->count(), $perPage, $page);
	}

	public function postReply(Discussion $discussion, array $data)
	{
		return $this->postsRepo->create($discussion, $data);
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

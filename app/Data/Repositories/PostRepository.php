<?php namespace Forums\Data\Repositories;

use stdClass;
use Discussion,
	Post as Model,
	PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

	protected $model;
	protected $discussionsRepo;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(Discussion $discussion, array $data)
	{
		// Create the post
		$post = $this->model->create([
			'user_id'	=> $data['user'],
			'content'	=> $data['content']
		]);

		// Associate it with the discussion
		$discussion->posts()->save($post);

		return $post;
	}

	public function paginate(Discussion $discussion, $page = 1, $perPage = 15)
	{
		// Start building the result set
		$result = new stdClass;
		$result->page = $page;
		$result->perPage = $perPage;
		$result->totalItems = 0;
		$result->items = [];

		// Build the offset
		$offset = $perPage * ($page - 1);

		// Fill in the result set
		$result->totalItems = $discussion->posts->count();
		$result->items = $discussion->posts->except(app('DiscussionRepository')->getFirstPost($discussion)->id)
			->slice($offset, $perPage);

		return $result;
	}

	public function reply(Discussion $discussion, array $data)
	{
		return $this->create($discussion, $data);
	}

}

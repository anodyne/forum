<?php namespace Forums\Data\Repositories;

use Discussion,
	Post as Model,
	PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

	protected $model;

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

}

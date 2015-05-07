<?php namespace Forums\Data\Repositories;

use Topic as Model,
	TopicRepositoryInterface;

class TopicRepository extends BaseRepository implements TopicRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all(array $with = [])
	{
		$query = (count($with) == 0)
			? $this->make(['discussions', 'discussions.posts', 'discussions.posts.author', 'parent'])
			: $this->make($with);

		return $query->get();
	}

	public function allParents()
	{
		$query = $this->make(['children', 'children.parent']);

		return $query->parents()->orderBy('name')->get();
	}

	public function getChildrenTopics(Model $model)
	{
		return $model->children;
	}

	public function getDiscussions(Model $model)
	{
		return $model->discussions;
	}

	public function getParentTopic(Model $model)
	{
		return $model->parent;
	}

	public function getTopicBySlug($slug)
	{
		return $this->getFirstBy('slug', $slug, [
			'discussions', 'discussions.posts', 'discussions.posts.author', 'children', 'parent', 'children.discussions', 'children.discussions.posts', 'children.discussions.posts.author'
		]);
	}

}

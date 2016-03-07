<?php namespace App\Data\Repositories;

use stdClass;
use Topic as Model,
	TopicRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

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

	public function allParents(array $with = [])
	{
		$query = (count($with) == 0)
			? $this->make(['children', 'children.parent'])
			: $this->make($with);

		return $query->parents()->orderBy('name')->get();
	}

	public function getBySlug($slug)
	{
		return $this->getFirstBy('slug', $slug, ['discussions', 'parent', 'children']);
	}

	public function getChildrenTopics(Model $model)
	{
		if ($model->children)
		{
			return $model->children
				->load('parent', 'discussions', 'discussions.posts', 'discussions.posts.author');
		}

		return null;
	}

	public function getDiscussions(Model $model)
	{
		return $model->discussions->load('posts', 'posts.author', 'topic', 'author');
	}

	public function getParentTopic(Model $model)
	{
		if ($model->parent)
		{
			return $model->parent->load('discussions.posts', 'discussions.posts.author');
		}

		return null;
	}

	public function listAll($value, $key)
	{
		// Get all the parents
		$parents = $this->allParents();

		$list = [];

		foreach ($parents as $parent)
		{
			$list[$parent->{$key}] = $parent->present()->{$value}();

			if ($parent->children->count() > 0)
			{
				foreach ($parent->children as $child)
				{
					$list[$child->{$key}] = $child->present()->{$value}();
				}
			}
		}

		return $list;
	}

	public function paginateDiscussions(Model $model, $page = 1, $perPage = 25)
	{
		// Get the discussions
		$discussions = $this->getDiscussions($model);

		// Build the offset
		$offset = ($page * $perPage) - $perPage;

		// Get the items for the current page
		$itemsForCurrentPage = $discussions->slice($offset, $perPage);

		return new LengthAwarePaginator($itemsForCurrentPage, $discussions->count(), $perPage, $page);
	}

}

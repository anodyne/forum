<?php namespace Forums\Data\Repositories;

use Discussion as Model,
	DiscussionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class DiscussionRepository extends BaseRepository implements DiscussionRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function paginateAll($page = 1, $perPage = 25)
	{
		// Start building the query
		$query = $this->make(['posts', 'posts.author', 'topic', 'topic.parent', 'author']);

		// Get the discussions
		$discussions = $query->orderBy('updated_at', 'desc')->get();

		// Build the offset
		$offset = ($page * $perPage) - $perPage;

		// Get the items for the current page
		$itemsForCurrentPage = $discussions->slice($offset, $perPage);

		return new LengthAwarePaginator($itemsForCurrentPage, $discussions->count(), $perPage, $page);
	}

}

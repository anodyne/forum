<?php namespace Forums\Data\Repositories;

use stdClass;

abstract class BaseRepository {

	public function all(array $with = [])
	{
		$query = $this->make($with);

		return $query->get();
	}

	public function count()
	{
		return $this->model->count();
	}

	public function countBy($key, $value, array $with = [])
	{
		$query = $this->make($with);

		return $query->where($key, $value)->count();
	}

	public function getById($id, array $with = [])
	{
		$query = $this->make($with);

		return $query->find($id);
	}

	public function getByPage($page = 1, $perPage = 10, array $with = [], $items = false)
	{
		// Start building the result set
		$result = new stdClass;
		$result->page = $page;
		$result->perPage = $perPage;
		$result->totalItems = 0;
		$result->items = [];

		// Build the offset
		$offset = $perPage * ($page - 1);

		if ($items)
		{
			// Eager load if necessary
			$items = $items->load($with);

			// Fill in the result set
			$result->totalItems = ($items->count() == $perPage) ? $this->count() : $items->count();
			$result->items = $items->slice($offset, $perPage);
		}
		else
		{
			// Build the query
			$query = $this->make($with)->skip($offset)->take($perPage);

			// Execute the query
			$model = $query->get();

			// Fill in the result set
			$result->totalItems = $this->count();
			$result->items = $model->all();
		}

		return $result;
	}

	public function getFirstBy($key, $value, array $with = [])
	{
		return $this->make($with)->where($key, '=', $value)->first();
	}

	public function getManyBy($key, $value, array $with = [])
	{
		return $this->make($with)->where($key, '=', $value)->get();
	}

	public function has($relation, array $with = [])
	{
		$entity = $this->make($with);

		return $entity->has($relation)->get();
	}

	public function listAll($value, $key)
	{
		return $this->model->lists($value, $key);
	}

	public function listAllBy($key, $value, $displayValue, $displayKey)
	{
		return $this->model->where($key, '=', $value)
			->lists($displayValue, $displayKey);
	}

	public function listAllFiltered($value, $key, $filters)
	{
		// Get the list of all the items
		$items = $this->listAll($value, $key);

		// Make sure we have an array of filters
		$filters = ( ! is_array($filters)) ? [$filters] : $filters;

		foreach ($filters as $filter)
		{
			unset($items[$filter]);
		}

		return $items;
	}

	public function make(array $with = [])
	{
		return $this->model->with($with);
	}

}

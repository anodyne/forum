<?php namespace Forums\Data\Interfaces;

interface DiscussionRepositoryInterface extends BaseRepositoryInterface {

	public function paginateAll($page = 1, $perPage = 25);

}

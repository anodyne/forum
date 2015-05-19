<?php namespace Forums\Data\Interfaces;

use Discussion;

interface PostRepositoryInterface extends BaseRepositoryInterface {

	public function create(Discussion $discussion, array $data);
	public function paginate(Discussion $discussion, $page = 1, $perPage = 15);
	public function reply(Discussion $discussion, array $data);

}

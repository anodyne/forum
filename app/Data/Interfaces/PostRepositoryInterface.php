<?php namespace Forums\Data\Interfaces;

use Discussion;

interface PostRepositoryInterface extends BaseRepositoryInterface {

	public function create(Discussion $discussion, array $data);

}

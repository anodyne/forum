<?php namespace Forums\Data\Interfaces;

use Discussion;

interface DiscussionRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function getDiscussion($topicSlug, $dicussionSlug);
	public function paginateAll($page = 1, $perPage = 25);
	public function postReply(Discussion $discussion, array $data);

}

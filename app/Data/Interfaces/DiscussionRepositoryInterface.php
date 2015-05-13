<?php namespace Forums\Data\Interfaces;

use Discussion;

interface DiscussionRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function getAnswer(Discussion $discussion);
	public function getDiscussion($topicSlug, $dicussionSlug);
	public function getFirstPost(Discussion $discussion);
	public function paginateAll($page = 1, $perPage = 20);
	public function paginatePosts(Discussion $discussion, $page = 1, $perPage = 15);
	public function postReply(Discussion $discussion, array $data);

}

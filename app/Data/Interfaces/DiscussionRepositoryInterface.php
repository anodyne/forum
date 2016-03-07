<?php namespace App\Data\Interfaces;

use Discussion;

interface DiscussionRepositoryInterface extends BaseRepositoryInterface {

	public function create(array $data);
	public function getAnswer(Discussion $discussion);
	public function getDiscussion($topicSlug, $dicussionSlug);
	public function getFirstPost(Discussion $discussion);
	public function paginate($page = 1, $perPage = 20);

}

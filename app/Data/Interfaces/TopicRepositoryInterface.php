<?php namespace App\Data\Interfaces;

use Topic;

interface TopicRepositoryInterface extends BaseRepositoryInterface {

	public function allParents();
	public function getBySlug($slug);
	public function getChildrenTopics(Topic $topic);
	public function getDiscussions(Topic $topic);
	public function getParentTopic(Topic $topic);
	public function paginateDiscussions(Topic $topic, $page = 1, $perPage = 25);

}

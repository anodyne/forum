<?php namespace Forums\Data\Interfaces;

use Topic;

interface TopicRepositoryInterface extends BaseRepositoryInterface {

	public function allParents();
	public function getChildrenTopics(Topic $topic);
	public function getDiscussions(Topic $topic);
	public function getParentTopic(Topic $topic);
	public function getTopicBySlug($slug);

}

<?php namespace Forums\Data\Interfaces;

interface DiscussionRepositoryInterface extends BaseRepositoryInterface {

	public function getDiscussion($topicSlug, $slug);

}

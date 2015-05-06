<?php namespace Forums\Data\Interfaces;

interface ConversationRepositoryInterface extends BaseRepositoryInterface {

	public function getConversation($topicSlug, $slug);

}

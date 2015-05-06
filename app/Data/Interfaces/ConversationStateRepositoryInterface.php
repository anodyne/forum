<?php namespace Forums\Data\Interfaces;

use User, Conversation, ConversationState;

interface ConversationStateRepositoryInterface extends BaseRepositoryInterface {

	public function getStateForCurrentUser(User $user, Conversation $conversation);
	public function updateState(ConversationState $state);

}

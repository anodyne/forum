<?php namespace Forums\Data;

use Model;

class ConversationState extends Model {

	public $timestamps = false;
	
	protected $table = 'conversations_states';
	
	protected $fillable = ['conversation_id', 'user_id', 'last_visited'];
	
	protected $dates = ['last_visited'];
	
}

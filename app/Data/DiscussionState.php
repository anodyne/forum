<?php namespace App\Data;

use Model;

class DiscussionState extends Model {

	public $timestamps = false;
	
	protected $table = 'discussions_states';
	
	protected $fillable = ['discussion_id', 'user_id', 'last_visited'];
	
	protected $dates = ['last_visited'];
	
}

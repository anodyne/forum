<?php namespace Forums\Data;

use Str, Auth, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model {

	use SoftDeletes, PresentableTrait;

	protected $table = 'conversations';

	protected $fillable = ['title', 'slug', 'answer_id', 'topic_id', 'user_id'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Forums\Data\Presenters\ConversationPresenter';

	/*
	|---------------------------------------------------------------------------
	| Accessors/Mutators
	|---------------------------------------------------------------------------
	*/

	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = (empty($value))
			? Str::slug($this->attributes['title'])
			: $value;
	}

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function posts()
	{
		return $this->hasMany('Post')->orderBy('created_at', 'asc');
	}

	public function stateForUser()
	{
		return $this->hasOne('ConversationState')->where('user_id', Auth::id());
	}

	public function topic()
	{
		return $this->belongsTo('Topic');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeSlug($query, $slug)
	{
		$query->where('slug', $slug);
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function countReplies()
	{
		return $this->posts->count() - 1;
	}

	public function hasNewReplies()
	{
		if ( ! $state = $this->stateForUser) return true;

		return $this->updated_at > $state->last_visited;
	}

	public function getStatusAttribute()
	{
		if ($this->hasNewReplies()) return 'updated';
	}

}

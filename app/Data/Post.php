<?php namespace App\Data;

use Str, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

	use SoftDeletes, PresentableTrait;

	protected $table = 'posts';

	protected $fillable = ['discussion_id', 'user_id', 'content'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $touches = ['discussion'];

	protected $presenter = 'App\Data\Presenters\PostPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function discussion()
	{
		return $this->belongsTo('Discussion');
	}

	public function isAnswer()
	{
		return $this->belongsTo('Discussion', 'id', 'answer_id');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Methods
	|---------------------------------------------------------------------------
	*/

	public function authorCanEdit(User $user)
	{
		if ( ! $this->isAuthor($user)) return false;

		if ( ! $user->can('forums.post.edit') and $this->created_at->diffInMinutes() < 60) return true;

		return false;
	}

	public function isAuthor(User $user)
	{
		return (bool) ($this->user_id == $user->id);
	}

}

<?php namespace Forums\Data;

use Str, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model {

	use SoftDeletes, PresentableTrait;

	protected $table = 'posts';

	protected $fillable = ['discussion_id', 'user_id', 'content'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $touches = ['discussion'];

	protected $presenter = 'Forms\Data\Presenters\PostPresenter';

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

}

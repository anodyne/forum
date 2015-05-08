<?php namespace Forums\Data;

use Str, Model;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model {

	use SoftDeletes, PresentableTrait;

	protected $table = 'topics';

	protected $fillable = ['name', 'slug', 'color', 'description', 'parent_id'];

	protected $dates = ['created_at', 'updated_at', 'deleted_at'];

	protected $presenter = 'Forums\Data\Presenters\TopicPresenter';

	/*
	|---------------------------------------------------------------------------
	| Accessors/Mutators
	|---------------------------------------------------------------------------
	*/

	public function setSlugAttribute($value)
	{
		$this->attributes['slug'] = (empty($value))
			? Str::slug($this->attributes['name'])
			: $value;
	}

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function children()
	{
		return $this->hasMany('Topic', 'parent_id', 'id');
	}

	public function discussions()
	{
		return $this->hasMany('Discussion')->orderBy('updated_at', 'desc');
	}

	public function parent()
	{
		return $this->belongsTo('Topic', 'parent_id');
	}

	/*
	|---------------------------------------------------------------------------
	| Model Scopes
	|---------------------------------------------------------------------------
	*/

	public function scopeParents($query)
	{
		$query->where('parent_id', null);
	}

	public function scopeSlug($query, $slug)
	{
		$query->where('slug', $slug);
	}

}

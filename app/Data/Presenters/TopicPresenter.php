<?php namespace Forums\Data\Presenters;

use Str, Markdown;
use Laracasts\Presenter\Presenter;

class TopicPresenter extends Presenter {

	public function color()
	{
		return $this->entity->color;
	}

	public function description()
	{
		return Markdown::parse($this->entity->description);
	}

	public function discussionCount()
	{
		$count = $this->entity->discussions->count();

		return partial('item-count', [
			'count'	=> $count,
			'label'	=> Str::plural('discussion', $count),
		]);
	}

	public function lastUpdate()
	{
		if ($this->entity->discussions->count() > 0)
		{
			// Get the latest discussion in the topic
			$discussion = $this->entity->discussions->first();

			return $discussion->present()->updatedAt." ".$discussion->present()->updatedBy;
		}

		return false;
	}

	public function name()
	{
		if ($this->entity->parent_id !== null)
		{
			return $this->entity->parent->present()->name.' - '.$this->entity->name;
		}

		return $this->entity->name;
	}

	public function nameAsLabel()
	{
		return partial('topic', [
			'content'	=> $this->name(),
			'color'		=> $this->color(),
			'slug'		=> $this->slug(),
		]);
	}

	public function nameAsLink()
	{
		return link_to_route('topic', $this->name(), [$this->slug()]);
	}

	public function slug()
	{
		return $this->entity->slug;
	}

}

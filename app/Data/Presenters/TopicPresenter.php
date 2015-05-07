<?php namespace Forums\Data\Presenters;

use Str, Markdown;
use Laracasts\Presenter\Presenter;

class TopicPresenter extends Presenter {

	public function color()
	{
		return $this->entity->color;
	}

	public function conversationCount()
	{
		return partial('count', [
			'count'	=> $this->entity->conversations->count(),
			'label'	=> Str::plural('conversation', $this->entity->conversations->count()),
		]);
	}

	public function description()
	{
		return Markdown::parse($this->entity->description);
	}

	public function lastUpdate()
	{
		// Get the latest conversation in the topic
		$conversation = $this->entity->conversations->sortByDesc('updated_at')->first();

		return $conversation->present()->updated." ".$conversation->present()->updatedBy;
	}

	public function name()
	{
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

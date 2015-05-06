<?php namespace Forums\Data\Presenters;

use Laracasts\Presenter\Presenter;

class TopicPresenter extends Presenter {

	public function color()
	{
		return $this->entity->color;
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function nameAsLabel()
	{
		return partial('topic', [
			'content'	=> $this->name(),
			'color'		=> $this->color()
		]);
	}

}

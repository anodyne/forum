<?php namespace Forums\Data\Presenters;

use Laracasts\Presenter\Presenter;

class ConversationPresenter extends Presenter {

	public function title()
	{
		return '<p class="lead"><strong>'.$this->entity->title.'</strong></p>';
	}

	public function topic()
	{
		return $this->entity->topic->present()->nameAsLabel;
	}

	public function updated()
	{
		return "Updated ".$this->entity->updated_at->diffForHumans();
	}

	public function updatedBy()
	{
		return "by ".$this->entity->posts->last()->author->present()->name;
	}

}

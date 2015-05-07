<?php namespace Forums\Data\Presenters;

use Str, Auth;
use Laracasts\Presenter\Presenter;

class ConversationPresenter extends Presenter {

	public function authorAvatar($linkToProfile = true)
	{
		return $this->entity->author->present()->avatar([
			'type' => 'link',
			'link' => '#',
			'class' => 'avatar avatar-sm img-circle'
		]);
	}

	public function title()
	{
		$updated = mt_rand(0, 1);

		$updatedString = (Auth::check() and $updated) ? ' updated' : false;

		return '<a href="'.route('home').'" class="list-item-title'.$updatedString.'">'.$this->entity->title.'</a>';
	}

	public function replyCount()
	{
		return partial('count', [
			'count'	=> $this->entity->posts->count() - 1,
			'label' => Str::plural('reply', ($this->entity->posts->count() - 1)),
		]);
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
		return "by <a href='#'>".$this->entity->posts->last()->author->present()->name."</a>";
	}

}

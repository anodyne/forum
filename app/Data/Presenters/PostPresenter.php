<?php namespace App\Data\Presenters;

use Markdown;
use Laracasts\Presenter\Presenter;

class PostPresenter extends Presenter {

	public function author()
	{
		return $this->entity->author->present()->name;
	}

	public function authorAsLink()
	{
		return link_to_route('profile', $this->author(), [$this->entity->author->username]);
	}

	public function authorAvatar($linkToProfile = true)
	{
		return $this->entity->author->present()->avatar([
			'type' => 'link',
			'link' => route('profile', [$this->entity->author->username]),
			'class' => 'avatar avatar-sm img-circle'
		]);
	}

	public function content()
	{
		return Markdown::parse($this->entity->content);
	}

	public function posted()
	{
		if ($this->entity->updated_at != $this->entity->created_at)
			return "Updated ".$this->entity->updated_at->diffForHumans();

		return "Posted ".$this->entity->created_at->diffForHumans();
	}

}

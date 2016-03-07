<?php namespace App\Data\Presenters;

use Str, Auth;
use Laracasts\Presenter\Presenter;

class DiscussionPresenter extends Presenter {

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

	public function title()
	{
		return $this->entity->title;
	}

	public function titleAsLink()
	{
		// Get the status for the discussion
		$status = (Auth::check()) ? $this->entity->getStatusAttribute() : false;

		return link_to_route('discussion.show', $this->title(), [$this->entity->topic->slug, $this->entity->slug], ['class' => "list-item-title{$status}"]);
	}

	public function replyCount()
	{
		return partial('item-count', [
			'count'	=> $this->entity->posts->count() - 1,
			'label' => Str::plural('reply', ($this->entity->posts->count() - 1)),
		]);
	}

	public function topic()
	{
		return $this->entity->topic->present()->nameAsLabel;
	}

	public function updatedAt()
	{
		return "Updated ".$this->entity->updated_at->diffForHumans();
	}

	public function updatedBy()
	{
		// Grab the author of the last post
		$author = $this->entity->posts->last()->author;

		return "by ".link_to_route('profile', $author->present()->name, [$author->username]);
	}

}

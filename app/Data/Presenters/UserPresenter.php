<?php namespace Forums\Data\Presenters;

use Gravatar,
	Markdown;
use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter {

	public function avatar(array $options)
	{
		// Figure out the default image
		$defaultImage = (app('env') != 'local') 
			? urlencode(asset('images/avatars/no-avatar.jpg')) 
			: 'retro' ;

		// Build the URL for the avatar
		$url = Gravatar::image($this->entity->email, 500)."&r=pg&d={$defaultImage}";

		// Merge all the options to pass them to the partial
		$mergedOptions = $options + ['url' => $url];

		return view('partials.image')->with($mergedOptions);
	}

	public function email()
	{
		return $this->entity->email;
	}

	public function name()
	{
		return $this->entity->name;
	}

	public function points()
	{
		return number_format($this->entity->points);
	}

	public function signature()
	{
		return $this->entity->signature;
	}

}

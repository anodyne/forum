<?php namespace Forums\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'Forums\Events\DiscussionWasCreated' => [
			'Forums\Handlers\Events\CalculatePoints',
		],
		'Forums\Events\DiscussionWasAnswered' => [
			'Forums\Handlers\Events\CalculatePoints',
		],
		'Forums\Events\DiscussionWasUpdated' => [
			//
		],
		'Forums\Events\PostWasCreated' => [
			'Forums\Handlers\Events\CalculatePoints',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		//
	}

}

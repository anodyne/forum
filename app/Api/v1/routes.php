<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['prefix' => 'api', 'middleware' => 'auth:api'], function ($api) {

	$api->get('discussions/{topic}', 'Api\V1\Controllers\DiscussionController@index');
	$api->get('discussions/{topic}/{id}', 'Api\V1\Controllers\DiscussionController@show');
	$api->post('discussions', 'Api\V1\Controllers\DiscussionController@store');
	//$api->put('discussions/{id}', 'Api\V1\Controllers\DiscussionController@update');
	//$api->delete('discussions/{id}', 'Api\V1\Controllers\DiscussionController@destroy');

	$api->get('posts/{discussion}', 'Api\V1\Controllers\PostController@index');
	$api->get('posts/{discussion}/{id}', 'Api\V1\Controllers\PostController@show');
	$api->post('posts', 'Api\V1\Controllers\PostController@store');
	//$api->put('posts/{id}', 'Api\V1\Controllers\PostController@update');
	//$api->delete('posts/{id}', 'Api\V1\Controllers\PostController@destroy');
	
	$api->resource('topics', 'Api\V1\Controllers\TopicController', ['except' => ['create', 'edit', 'update', 'destroy']]);

});

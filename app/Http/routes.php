<?php

Route::get('/', [
	'as'	=> 'home',
	'uses'	=> 'DiscussionController@index']);

/**
 * Topic landing pages
 */
Route::get('topics', [
	'as'	=> 'topics',
	'uses'	=> 'TopicController@index']);
Route::get('topic/{slug}', [
	'as'	=> 'topic',
	'uses'	=> 'TopicController@show']);

/**
 * Authentication
 */
Route::get('login', [
	'as'	=> 'login',
	'uses'	=> 'LoginController@index']);
Route::post('login', 'LoginController@doLogin');
Route::get('logout', [
	'as'	=> 'logout',
	'uses'	=> 'LoginController@logout']);

/**
 * Search
 */
Route::group(['prefix' => 'search'], function()
{
	Route::get('/', [
		'as'	=> 'search.do',
		'uses'	=> 'SearchController@doSearch']);
	Route::get('advanced', [
		'as'	=> 'search.advanced',
		'uses'	=> 'SearchController@advanced']);
	Route::get('advanced/results', [
		'as'	=> 'search.doAdvanced',
		'uses'	=> 'SearchController@doAdvancedSearch']);
});

/**
 * Discussions
 */
Route::group(['prefix' => 'discussion'], function()
{
	Route::get('create', [
		'as'	=> 'discussion.create',
		'uses'	=> 'DiscussionController@create']);
	Route::post('/', [
		'as'	=> 'discussion.store',
		'uses'	=> 'DiscussionController@store']);
	Route::get('{topicSlug}/{discussionSlug}/edit', [
		'as'	=> 'discussion.edit',
		'uses'	=> 'DiscussionController@edit']);
	Route::put('{topicSlug}/{discussionSlug}', [
		'as'	=> 'discussion.update',
		'uses'	=> 'DiscussionController@update']);
	Route::get('{topicSlug}/{discussionSlug}/remove', [
		'as'	=> 'discussion.remove',
		'uses'	=> 'DiscussionController@remove']);
	Route::delete('{topicSlug}/{discussionSlug}', [
		'as'	=> 'discussion.destroy',
		'uses'	=> 'DiscussionController@destroy']);
	Route::post('{topicSlug}/{discussionSlug}/reply', [
		'as'	=> 'discussion.reply',
		'uses'	=> 'DiscussionController@storeReply']);
});

Route::get('discussion/{topicSlug}/{discussionSlug}', [
	'as'	=> 'discussion.show',
	'uses'	=> 'DiscussionController@show']);

/**
 * User profile and discussions
 */
Route::get('profile/{username}', [
	'as'	=> 'profile',
	'uses'	=> 'UserController@show']);
Route::get('user/discussions/{username?}', [
	'as'	=> 'user.discussions',
	'uses'	=> 'UserController@discussions']);

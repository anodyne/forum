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
Route::resource('discussion', 'DiscussionController');
Route::post('discussion/{topicSlug/{discussionSlug}/reply', [
	'as'	=> 'discussion.quick-reply',
	'uses'	=> 'DiscussionController@storeQuickReply']);
Route::get('discussion/{topicSlug}/{discussionSlug}', [
	'as'	=> 'discussion.show',
	'uses'	=> 'DiscussionController@show']);

/**
 * User profile
 */
Route::get('profile/{username}', [
	'as'	=> 'profile',
	'uses'	=> 'UserController@show']);

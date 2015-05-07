<?php

Route::get('/', [
	'as'	=> 'home',
	'uses'	=> 'MainController@index']);

Route::get('topics', [
	'as'	=> 'topics',
	'uses'	=> 'TopicController@index']);
Route::get('topic/{slug}', [
	'as'	=> 'topic',
	'uses'	=> 'TopicController@show']);

Route::get('conversation/{topicSlug}/{conversationId}', [
	'as'	=> 'conversation',
	'uses'	=> 'MainController@conversation']);

Route::get('login', [
	'as'	=> 'login',
	'uses'	=> 'LoginController@index']);
Route::get('logout', [
	'as'	=> 'logout',
	'uses'	=> 'LoginController@logout']);
Route::post('login', 'LoginController@doLogin');

Route::get('advanced-search', [
	'as'	=> 'search.advanced',
	'uses'	=> 'SearchController@advanced']);
Route::get('search', [
	'as'	=> 'search.do',
	'uses'	=> 'SearchController@doSearch']);
Route::get('advanced-results', [
	'as'	=> 'search.doAdvanced',
	'uses'	=> 'SearchController@doAdvancedSearch']);

<?php

Route::get('/', [
	'as'	=> 'home',
	'uses'	=> 'MainController@index']);

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

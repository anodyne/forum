@extends('layouts.master')

@section('title')
	All Topics
@stop

@section('content')
	<h1>All Topics</h1>

	{!! partial('topics-list', ['topics' => $topics, 'includeChildren' => true]) !!}
@stop
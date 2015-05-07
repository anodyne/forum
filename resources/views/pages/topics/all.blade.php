@extends('layouts.master')

@section('title')
	All Topics
@stop

@section('content')
	<h1>All Topics</h1>

	<div class="row">
		<div class="col-md-4 col-lg-3">
			{!! partial('forum-controls', ['topics' => $allTopics, 'includeAllDiscussionsLink' => true, 'includeAllTopicsLink' => false]) !!}
		</div>

		<div class="col-md-8 col-lg-9">
			{!! partial('topics-list', ['topics' => $topics]) !!}
		</div>
	</div>
@stop

@section('modals')
	@if ($_currentUser)
		{!! modal(['id' => 'newDiscussion', 'header' => "Start a Discussion"]) !!}
	@endif
@stop

@section('scripts')
@stop
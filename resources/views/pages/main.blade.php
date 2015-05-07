@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	<div class="row">
		<div class="col-md-4 col-lg-3">
			{!! partial('forum-controls', ['topics' => $topics, 'includeAllDiscussionsLink' => false, 'includeAllTopicsLink' => true]) !!}
		</div>

		<div class="col-md-8 col-lg-9">
			{!! partial('discussions-list', ['discussions' => $discussions]) !!}
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
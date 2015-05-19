@extends('layouts.master')

@section('title')
	{{ $topic->present()->name }} Discussions
@stop

@section('content')
	<h1>{{ $topic->present()->name }}</h1>

	<div class="visible-xs visible-sm">
		<div class="row">
			@if ($_currentUser and $_currentUser->can('forums.discussion.create'))
				<div class="col-sm-6">
					<p><a href="{{ route('discussion.create') }}" class="btn btn-primary btn-lg btn-block">Start a Discussion</a></p>
				</div>
			@endif
			@if ($parent)
				<div class="col-sm-6">
					<p><a href="{{ route('topic', [$parent->slug]) }}" class="btn btn-default btn-lg btn-block">Back to {{ $parent->name }} Discussions</a></p>
				</div>
			@endif
		</div>
	</div>

	<div class="visible-md visible-lg">
		<div class="btn-toolbar">
			@if ($_currentUser and $_currentUser->can('forums.discussion.create'))
				<div class="btn-group">
					<a href="{{ route('discussion.create') }}" class="btn btn-primary">Start a Discussion</a>
				</div>
			@endif
			@if ($parent)
				<div class="btn-group">
					<a href="{{ route('topic', [$parent->slug]) }}" class="btn btn-default">Back to {{ $parent->name }} Discussions</a>
				</div>
			@endif
		</div>
	</div>

	{!! $topic->present()->description !!}

	@if ($children->count() > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">{{ $topic->name }} Sub Topics</h3>
			</div>
			<div class="panel-body">
				{!! partial('topics-list', ['topics' => $children, 'includeChildren' => false]) !!}
			</div>
		</div>
	@endif

	@if ($paginator->total() > 0)
		{!! $paginator->render() !!}

		{!! partial('discussion-list', ['discussions' => $paginator]) !!}

		{!! $paginator->render() !!}
	@else
		{!! alert('warning', "No {$topic->name} discussions found.") !!}
	@endif
@stop

@section('modals')
	@if ($_currentUser)
		{!! modal(['id' => 'newDiscussion', 'header' => "Start a Discussion"]) !!}
	@endif
@stop

@section('scripts')
@stop
@extends('layouts.master')

@section('title')
	Conversations by Topic
@stop

@section('content')
	<h1>Conversations by Topic <small>{{ $topic->present()->name }}</small></h1>

	<div class="visible-xs visible-sm">
		<div class="row">
			<div class="col-xs-12">
				<p><a href="#" class="btn btn-primary btn-lg btn-block">Start a Conversation</a></p>
			</div>
		</div>
	</div>
	<div class="visible-md visible-lg">
		<div class="btn-toolbar">
			<div class="btn-group">
				<a href="#" class="btn btn-primary btn-lg">Start a Conversation</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="threads">
			@foreach ($topic->conversations as $conversation)
				{!! partial('thread', ['conversation' => $conversation]) !!}
			@endforeach
			</div>
		</div>
	</div>
@stop
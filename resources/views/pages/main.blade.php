@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
	@if ($_currentUser)
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
	@endif

	<div class="row">
		<div class="col-md-8">
			<div class="data-list">
			@foreach ($conversations as $conversation)
				{!! partial('thread', ['conversation' => $conversation]) !!}
			@endforeach
			</div>
		</div>

		<div class="col-md-4">
			<h3>Forum Leaderboard</h3>
		</div>
	</div>
@stop
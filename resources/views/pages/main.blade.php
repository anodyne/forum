@extends('layouts.master')

@section('title')
	Home
@stop

@section('content')
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
		<div class="col-md-9">
			<div class="data-table data-table-bordered data-table-striped">
			@foreach ($conversations as $conversation)
				<div class="row">
					<div class="col-md-10">
						{!! $conversation->present()->title !!}
						<p>
							{!! $conversation->present()->topic !!}
							<span class="text-sm text-muted">
								{!! $conversation->present()->updated !!}
								{!! $conversation->present()->updatedBy !!}
							</span>
						</p>
					</div>
					<div class="col-md-2">
						<div class="text-center">
							<p class="lead"><strong>{{ $conversation->countReplies() }}</strong></p>
							<p class="text-muted">{{ Str::plural('Reply', $conversation->countReplies()) }}</p>
						</div>
					</div>
				</div>
			@endforeach
			</div>
		</div>

		<div class="col-md-3">
			<h3>Forum Leaderboard</h3>
		</div>
	</div>
@stop
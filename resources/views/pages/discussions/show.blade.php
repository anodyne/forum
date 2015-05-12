@extends('layouts.master')

@section('title')
	{{ $discussion->title }}
@stop

@section('content')
	<h1>{!! $discussion->present()->title !!}</h1>

	<p>{!! $discussion->present()->topic !!}</p>

	{!! partial('post', ['post' => $firstPost, 'discussion' => $discussion, 'footer' => false]) !!}

	<span class="discussion-summary">
		{{ $discussion->countReplies() }} {{ Str::plural('reply', $discussion->countReplies()) }}

		@if ($discussion->answer)
			with 1 correct anwer
		@endif
	</span>

	@if ($answer)
		{!! partial('post', ['post' => $answer, 'discussion' => $discussion, 'footer' => false]) !!}
	@endif

	@if ($posts->count() > 0)
		@foreach ($posts as $post)
			{!! partial('post', ['post' => $post, 'discussion' => $discussion, 'footer' => true]) !!}
		@endforeach
	@endif

	<span class="discussion-summary">
		<div class="checkbox-inline">
			<label>{!! Form::checkbox('notify', true, false) !!} Notify me of any updates to this discussion</label>
		</div>
	</span>

	<hr class="partial-split">

	<div class="media">
		<div class="media-left">
			{!! $_currentUser->present()->avatar([
				'type' => 'link',
				'link' => route('profile', [$_currentUser->username]),
				'class' => 'avatar avatar-sm img-circle'
			]) !!}
		</div>
		<div class="media-body">
			<div class="form-group">
				{!! Form::textarea('reply', null, ['class' => 'form-control']) !!}
				<p class="help-block">{!! $_icons['markdown'] !!} Parsed as Markdown</p>
			</div>
			<div class="form-group">
				<div class="visible-xs visible-sm">
					{!! Form::button("Post a Reply", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
				</div>
				<div class="visible-md visible-lg">
					{!! Form::button("Post a Reply", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>
	</div>
@stop
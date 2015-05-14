@extends('layouts.master')

@section('title')
	Start a Discussion
@stop

@section('content')
	<h1>Start a Discussion</h1>

	{!! Form::model($discussion, ['route' => ['discussion.update', $discussion->topic->slug, $discussion->slug], 'method' => 'put', 'class' => 'form-horizontal']) !!}
		<div class="form-group">
			<label class="control-label col-md-2">Pick a Topic</label>
			<div class="col-md-4">
				{!! Form::select('topic', $topics, null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<label class="control-label col-md-2">Title</label>
			<div class="col-md-6">
				{!! Form::text('title', null, ['class' => 'form-control input-lg']) !!}
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-2">
				<div class="visible-xs visible-sm">
					{!! Form::button("Update Discussion", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
				</div>
				<div class="visible-md visible-lg">
					{!! Form::button("Update Discussion", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop
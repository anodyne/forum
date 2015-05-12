@extends('layouts.master')

@section('title')
	Start a Discussion
@stop

@section('content')
	<h1>Start a Discussion</h1>

	{!! Form::open(['route' => 'discussion.store', 'class' => 'form-horizontal']) !!}
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
			<label class="control-label col-md-2">Content</label>
			<div class="col-md-8">
				{!! Form::textarea('content', null, ['class' => 'form-control input-lg', 'rows' => 15]) !!}
				<p class="help-block">{!! $_icons['markdown'] !!} Parsed with Markdown</p>
			</div>
		</div>

		<div class="form-group">
			<div class="col-md-6 col-md-offset-2">
				<div class="visible-xs visible-sm">
					{!! Form::button("Start Discussion", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}
				</div>
				<div class="visible-md visible-lg">
					{!! Form::button("Start Discussion", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>
	{!! Form::close() !!}
@stop
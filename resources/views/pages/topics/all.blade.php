@extends('layouts.master')

@section('title')
	All Topics
@stop

@section('content')
	<h1>All Topics</h1>

	<div class="data-list">
	@foreach ($topics as $topic)
		<div class="row">
			<div class="col-md-10">
				<p class="list-item-title updated">{!! $topic->present()->nameAsLink !!}</p>
				<span class="list-item-meta">{!! $topic->present()->description !!}</span>
				<p class="list-item-meta">{!! $topic->present()->lastUpdate !!}</p>
			</div>
			<div class="col-md-2">
				{!! $topic->present()->conversationCount !!}
			</div>
		</div>
	@endforeach
	</div>
@stop
<div class="forum-controls">
	@if ($_currentUser)
		<p><a href="#" class="btn btn-primary btn-lg btn-block">Start a Discussion</a></p>
	@endif

	<div class="visible-xs visible-sm">
		@if ($includeAllDiscussionsLink)
			<p><a href="{{ route('home') }}" class="btn btn-default btn-lg btn-block">All Discussions</a></p>
		@endif

		@if ($includeAllTopicsLink)
			<p><a href="{{ route('topics') }}" class="btn btn-default btn-lg btn-block">All Topics</a></p>
		@endif
	</div>

	<div class="visible-md visible-lg">
		@if ($includeAllDiscussionsLink)
			<p><a href="{{ route('home') }}" class="btn btn-default btn-block">All Discussions</a></p>
		@endif

		@if ($includeAllTopicsLink)
			<p><a href="{{ route('topics') }}" class="btn btn-default btn-block">All Topics</a></p>
		@endif
	</div>

	<div class="list-group">
	@foreach ($topics as $topic)
		<a href="{{ route('topic', [$topic->slug]) }}" class="list-group-item">
			<span class="badge" style="background-color:{{ $topic->color }}">&nbsp;</span>
			{{ $topic->name }}
		</a>

		@if ($topic->children->count() > 0)
			@foreach ($topic->children as $child)
				<a href="{{ route('topic', [$child->slug]) }}" class="list-group-item">
					<span class="badge" style="background-color:{{ $child->color }}">&nbsp;</span>
					{{ $child->name }}
					<br><em class="text-muted">{{ $child->parent->name }}</em>
				</a>
			@endforeach
		@endif
	@endforeach
	</div>
</div>
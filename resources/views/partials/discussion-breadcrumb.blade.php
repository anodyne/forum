<ul class="breadcrumb">
	<li><a href="{{ route('home') }}">Forum</a></li>
	
	@if ($topic->parent_id > 0)
		<li><a href="{{ route('topic', [$topic->parent->slug]) }}">{{ $topic->parent->name }}</a></li>
	@endif
	
	<li class="active"><a href="{{ route('topic', [$topic->slug]) }}">{{ $topic->name }}</a></li>
</ul>
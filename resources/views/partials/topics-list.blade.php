<div class="data-list">
@foreach ($topics as $topic)
	<div class="row">
		<div class="col-md-10">
			<p class="list-item-title updated">{!! $topic->present()->nameAsLink !!}</p>
			<span class="list-item-meta">{!! $topic->present()->description !!}</span>
			<p class="list-item-meta">{!! $topic->present()->lastUpdate !!}</p>
		</div>
		<div class="col-md-2">
			{!! $topic->present()->discussionCount !!}
		</div>
	</div>

	@if ($includeChildren)
		@foreach ($topic->children as $child)
			<div class="row">
				<div class="col-md-10">
					<p class="list-item-title updated">{!! $child->present()->nameAsLink !!}</p>
					<span class="list-item-meta">{!! $child->present()->description !!}</span>
					<p class="list-item-meta">{!! $child->present()->lastUpdate !!}</p>
				</div>
				<div class="col-md-2">
					{!! $child->present()->discussionCount !!}
				</div>
			</div>
		@endforeach
	@endif
@endforeach
</div>
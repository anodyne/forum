<div class="data-list">
@foreach ($discussions as $discussion)
	<div class="row">
		<div class="col-md-10">
			<div class="list-item-avatar">
				{!! $discussion->present()->authorAvatar !!}
				@if ($discussion->answer)
					<span class="list-item-answered" title="Discussion has a reply marked as a correct answer">{!! $_icons['check'] !!}</span>
				@endif
			</div>

			<div class="list-item-group">
				{!! $discussion->present()->titleAsLink !!}

				{!! $discussion->present()->topic !!}
				<span class="list-item-meta">
					{!! $discussion->present()->updatedAt !!}
					{!! $discussion->present()->updatedBy !!}
				</span>
			</div>
		</div>
		<div class="col-md-2">
			{!! $discussion->present()->replyCount !!}
		</div>
	</div>
@endforeach
</div>
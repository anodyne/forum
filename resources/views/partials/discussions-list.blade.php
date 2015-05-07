<div class="data-list">
@foreach ($discussions as $discussion)
	<div class="row">
		<div class="col-md-10">
			<div class="list-item-avatar">
				{!! $discussion->present()->authorAvatar !!}
			</div>

			<div class="list-item-group">
				{!! $discussion->present()->title !!}

				{!! $discussion->present()->topic !!}
				<span class="list-item-meta">
					{!! $discussion->present()->updated !!}
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
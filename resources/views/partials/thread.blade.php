<div class="row">
	<div class="col-md-10">
		<div class="list-item-avatar">
			{!! $conversation->present()->authorAvatar !!}
		</div>

		<div class="list-item-group">
			{!! $conversation->present()->title !!}

			{!! $conversation->present()->topic !!}
			<span class="list-item-meta">
				{!! $conversation->present()->updated !!}
				{!! $conversation->present()->updatedBy !!}
			</span>
		</div>
	</div>
	<div class="col-md-2">
		{!! $conversation->present()->replyCount !!}
	</div>
</div>
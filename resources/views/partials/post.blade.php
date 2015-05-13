<?php $class = ($discussion->answer and $discussion->answer->id == $post->id) ? 'panel-success' : 'panel-default';?>

<div class="media">
	<div class="media-left">
		{!! $post->present()->authorAvatar !!}
	</div>

	<div class="media-body">
		<div class="panel {{ $class }}">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="pull-right timestamp">{!! $post->present()->posted !!}</div>

					{!! $post->present()->authorAsLink !!}
					
					@if ($discussion->answer and $discussion->answer->id == $post->id)
						&ndash; Best Answer
					@endif
				</h3>
			</div>
			<div class="panel-body">
				{!! $post->present()->content !!}
			</div>

			@if ($footer)
				<div class="panel-footer">
					<div class="visible-xs visible-sm">
						@if ($discussion->isAuthor($_currentUser) and $discussion->answer and $discussion->answer->id != $post->id)
							<p><a href="#" class="btn btn-default btn-lg btn-block">Mark as the Best Answer</a></p>
						@endif
					</div>
					<div class="visible-md visible-lg">
						<div class="btn-toolbar">
							@if ($discussion->isAuthor($_currentUser) and $discussion->answer and $discussion->answer->id != $post->id)
								<div class="btn-group">
									<a href="#" class="btn btn-link">{!! $_icons['check'] !!}</a>
								</div>
							@endif

							<div class="btn-group">
								<a href="#" class="btn btn-link">{!! $_icons['edit'] !!}</a>
								<a href="#" class="btn btn-link">{!! $_icons['remove'] !!}</a>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
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

			@if (Auth::check())
				<div class="panel-footer">
					<div class="visible-xs visible-sm">
						@if ($discussion->isAuthor($_currentUser) and $discussion->answer and $discussion->answer->id != $post->id)
							<p><a href="#" class="btn btn-default btn-lg btn-block">Mark as the Best Answer</a></p>
						@endif
					</div>
					<div class="visible-md visible-lg">
						<div class="btn-toolbar pull-right">
							<div class="btn-group">
								<a href="#" class="btn" title="Copy the link to this post">{!! $_icons['link'] !!}</a>
							</div>
							<div class="btn-group">
								<a href="#" class="btn" title="Send the author a message">{!! $_icons['message'] !!}</a>
							</div>
							<div class="btn-group">
								<a href="#" class="btn" title="Report this post">{!! $_icons['warning'] !!}</a>
							</div>
						</div>

						<div class="btn-toolbar">
							@if ($discussion->answer and $discussion->answer->id != $post->id and ($_currentUser->can('forums.admin') or $discussion->isAuthor($_currentUser)))
								<div class="btn-group">
									<a href="#" class="btn">{!! $_icons['check'] !!}</a>
								</div>
							@endif

							@if ($_currentUser->can('forums.post.edit') or ($post->authorCanEdit($_currentUser)))
								<div class="btn-group">
									<a href="#" class="btn">{!! $_icons['edit'] !!}</a>
								</div>
							@endif

							@if ($_currentUser->can('forums.post.delete'))
								<div class="btn-group">
									<a href="#" class="btn">{!! $_icons['remove'] !!}</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
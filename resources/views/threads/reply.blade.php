<div class="card">
    <div class="card-header">
			<div class="level">
				<h5 class="flex">
					<a href="#">
						{{ $reply->owner->name }}
					</a> said {{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }} 
				</h5>

				<div>
					<form method="POST" action="/replies/{{ $reply->id }}/favorites">
					{{csrf_field()}}
						<button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
							{{ $reply->getFavoriteAttributeCount() }} {{ str_plural('favorite', $reply->getFavoriteAttributeCount()) }}
						</button>
					</form>
				</div>
			</div>
		</div>

    <div class="card-body">
		{{ $reply->body }}
	</div>
</div>
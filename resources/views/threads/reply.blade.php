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
							{{ $reply->favorites_count}} {{ str_plural('favorite', $reply->favorites_count) }}
						</button>
					</form>
				</div>
			</div>
		</div>

    <div class="card-body">
		{{ $reply->body }}
	</div>
</div>
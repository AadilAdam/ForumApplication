
<reply :attributes="{{ $reply }}" inline-template>
	<div id="reply-{{ $reply->id }}" class="card">
		<div class="card-header">
				<div class="level">
					<h5 class="flex">
						<a href="#">
							{{ $reply->owner->name }}
						</a> said {{ \Carbon\Carbon::parse($reply->created_at)->diffForHumans() }} 
					</h5>

					@if (Auth::check())
						<div>
							<favorite :reply="{{ $reply }}"></favorite>
						</div>
					@endif
				</div>
			</div>

		<div class="card-body">
			<div v-if="editing">
				<div class="form-group">
					<textarea class="form-control" name="" id="" rows="3" v-model="body">{{ $reply->body }}</textarea>
				</div>
				<button class="btn btn-sm btn-primary" @click="update">Update</button>
				<button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>
			</div>
			<div v-else v-text="body"></div>
		</div>

		@can ('update', $reply)
			<div class="card-footer d-flex">
				<button type="button" class="btn btn-secondary btn-sm mr-1" @click="editing = true">Edit</button>
				<button type="button" class="btn btn-danger btn-sm mr-1" @click="destroy">Delete</button>
			</div>
		@endcan
	</div>
</reply>
<div class="table-responsive marginTbl">

	<table class="table table-borderless table-fixed customTable longTbl">
		<thead>
			<tr>
				<th>Id</th>
				<th>Title</th>
				<th>Description</th>
				<th class="text-center">Image</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			
				<tr>
					<td>{{ $record->id }}</td>
					<td>{{ $record->title }}</td>
					<td>{{ $record->description }}</td>
					<td>
						@if(!empty($record->image))
							<img src="<?php echo config('app.url_public').'/'.$record->image; ?>" class="img-fluid w-100 img_user_face" />
						@endif
					</td>
				</tr>
				
			@endforeach
			@if(count($records) == 0)
				<tr>
					<td class="text-center" colspan="4">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $records->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
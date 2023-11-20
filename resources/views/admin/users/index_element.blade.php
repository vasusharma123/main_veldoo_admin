<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th>Name</th>
				<th>Surname</th>
				<th>Phone Number</th>
				<th>Email Address</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			
				<tr>
					<td>{{ $record->first_name }}</td>
					<td>{{ $record->last_name }}</td>
					<td>{{ $record->country_code.' '.$record->phone }}</td>
					<td>{{ $record->email }}</td>
					<td class="actionbtns">
						<!--<a href="#" class="actionbtnsLinks"><img src="{{ URL::asset('public') }}/assets/images/veldoo/editpen.png" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>-->
						<a href="javascript:void(0);" class="actionbtnsLinks delete_user" data-id="{{ $record->id }}"><img src="{{ URL::asset('public') }}/assets/images/veldoo/deleteBox.png" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
					</td>
				</tr>
				
			@endforeach
			@if(count($records) == 0)
				<tr>
					<td class="text-center" colspan="5">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $records->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
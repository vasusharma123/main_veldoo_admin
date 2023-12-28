<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Receiver</th>
				<th>Title</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
				<tr>
					<td>{{ $record->start_date }}</td>
					<td>{{ $record->end_date }}</td>
					<td>
					@if($record->type == 1)
						All Users
					@else
						Specific User
					@endif
					</td>
					<td>{{ $record->title }}</td>
					<td class="actionbtns">
						<!--<a href="{{ route('drivers.edit',$record->id) }}" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>-->
						<a href="javascript:void(0);" class="actionbtnsLinks delete_record" data-id="{{ $record->id }}"><img src="{{ asset('assets/images/veldoo/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
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
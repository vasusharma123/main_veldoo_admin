<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th>Company</th>
				<th>Name</th>
				<th>Surname</th>
				<th>Phone Number</th>
				<th>Email Address</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			
				<tr>
					<td>{{ $record->name }}</td>
					<td>{{ (!empty($record->user))?$record->user->first_name:"" }}</td>
					<td>{{ (!empty($record->user))?$record->user->last_name:"" }}</td>
					<td>{{ (!empty($record->user))? '+'.$record->user->country_code." ".$record->user->phone:"" }}</td>
					<td>{{ (!empty($record->user))?$record->user->email:"" }}</td>
					<td class="switch_btn">
						<label class="switch">
							<input type="checkbox" class="change_status" value="{{ $record->status }}" data-id="{{ $record->id }}" {{ $record->status == 1 ? "checked" : "" }}>
							<span class="slider round"></span>
						</label>
					</td>
					<td class="actionbtns">
						<a href="{{ route('company.edit',$record->id) }}" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
						<a href="javascript:void(0);" class="actionbtnsLinks delete_user" data-id="{{ $record->id }}"><img src="{{ asset('assets/images/veldoo/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
					</td>
				</tr>
				
			@endforeach
			@if(count($records) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $records->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
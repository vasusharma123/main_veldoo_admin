<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th>Owner Name</th>
				<th>Owner Email</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>State</th>
				<th>City</th>
				<th>Country</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			
				<tr>
					<td>{{ $record->name }}</td>
					<td>{{ $record->email }}</td>
					<td>{{ $record->company_name }}</td>
					<td>{{ $record->company_email }}</td>
					<td>{{ $record->company_country_code.' '.$record->company_phone }}</td>
					<td>{{ $record->company_state }}</td>
					<td>{{ $record->company_city }}</td>
					<td>{{ $record->company_country }}</td>
					<td class="switch_btn">
						<label class="switch">
							<input type="checkbox" class="change_status" value="{{ $record->company_status }}" data-id="{{ $record->company_id }}" {{ $record->company_status == 1 ? "checked" : "" }}>
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
					<td class="text-center" colspan="10">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $records->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
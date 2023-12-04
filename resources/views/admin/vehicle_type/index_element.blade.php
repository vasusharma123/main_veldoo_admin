<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th>Car Type</th>
				<th>Start fee</th>
				<th>Price per km</th>
				<th>Seating capacity</th>
				<th>Alert time</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			
				<tr>
					<td>{{ $record->car_type }}</td>
					<td>{{ $record->basic_fee }}</td>
					<td>{{ $record->price_per_km }}</td>
					<td>{{ $record->seating_capacity }}</td>
					<td>{{ $record->alert_time }}</td>
					<td class="actionbtns">
						<a href="{{ route('vehicle-type.edit',$record->id) }}" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
						<a href="javascript:void(0);" class="actionbtnsLinks delete_vehicle_type" data-id="{{ $record->id }}"><img src="{{ asset('assets/images/veldoo/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
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
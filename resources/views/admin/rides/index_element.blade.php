<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th class="text-center"><input type="checkbox" class="form-check-input parent_checkbox"></th>
				<th class="text-center">ID</th>
				<th>Date</th>
				<th>Driver</th>
				<th>Car</th>
				<th>Guest</th>
				<th>Pick Up</th>
				<th>Drop Off</th>
				<th class="text-center">Distance</th>
				<th class="text-center">Ride Cost</th>
				<th class="text-center">Status</th>
				<th >Payment Type</th>
				<th >Booking Method</th>
				<th >Phone Number</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($rides as $record)
			<tr>
				<td class="text-center"><input type="checkbox" class="form-check-input child_checkbox"></td>
				<td>{{ $record->id }}</td>
				<td>{{ date('d/m/Y', strtotime($record->ride_time)) }}</td>
				<td>{{ $record->first_name.' '.$record->last_name }}</td>
				<td>{{ $record->vehicle_number_plate }}</td>
				<td>{{ $record->guest_first_name.' '.$record->guest_last_name }}</td>
				<td>{{ $record->pickup_address }}</td>
				<td>{{ $record->dest_address }}</td>
				<td class="text-center">{{ $record->distance }}km</td>
				<td class="text-center">${{ $record->ride_cost }}</td>
				<td>
					@if ($record->status == 0)
						<span class="statusbord process">Process</span>
					@elseif ($record->status == 1)
						<span class="statusbord warning">Accepted By Driver</span>
					@elseif ($record->status == 2)
						<span class="statusbord warning">Ride Start</span>
					@elseif ($record->status == 3)
						<span class="statusbord done">Completed</span>
					@elseif ($record->status == 4)
						<span class="statusbord warning">Driver Reached To Customer </span>
					@elseif ($record->status == -2)
						<span class="statusbord warning">Cancelled</span>
					@elseif ($record->status == -4 or $record->status == 5)
						<span class="statusbord warning">Pending</span>
					@elseif ($record->status == -3)
						<span class="statusbord warning">Cancelled By Customer</span>
					@endif
				</td>
				<td>{{ ucfirst($record->payment_type) }}</td>
				<td>{{ $record->created_by_user_type }} {{ ucfirst($record->platform) }}</td>
				<td>{{ $record->user_country_code.'-'.$record->user_phone }}</td>
				<td class="actionbtns">
					<a href="rides_details.html" class="actionbtnsLinks"><i class="bi bi-eye viewRides"></i></a>
					<a href="#" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
				</td>
			</tr>
			@endforeach
			@if(count($rides) == 0)
				<tr>
					<td class="text-center" colspan="15">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $rides->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
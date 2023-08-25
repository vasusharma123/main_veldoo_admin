<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				User Name
			</th>
		<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Driver Name
			</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="pickup_address" order="asc">
				<i class="fa fa-fw @if($orderby == 'pickup_address' && $order=='asc') fa-sort-asc @elseif($orderby == 'pickup_address' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Pickup Location
			</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="dest_address" order="asc">
				<i class="fa fa-fw @if($orderby == 'dest_address' && $order=='asc') fa-sort-asc @elseif($orderby == 'dest_address' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Dropoff Location
			</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="price" order="asc">
				<i class="fa fa-fw @if($orderby == 'price' && $order=='asc') fa-sort-asc @elseif($orderby == 'price' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Price
			</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw @if($orderby == 'name' && $order=='asc') fa-sort-asc @elseif($orderby == 'name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Car Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="payment_type" order="asc">
				<i class="fa fa-fw @if($orderby == 'payment_type' && $order=='asc') fa-sort-asc @elseif($orderby == 'payment_type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Payment Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="payment_type" order="asc">
				<i class="fa fa-fw @if($orderby == 'payment_type' && $order=='asc') fa-sort-asc @elseif($orderby == 'payment_type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Ride Type
			</th>
		
			<th>Status</th>
			<th>Action</th>
		</thead>
		<tbody>
		@foreach ($array as $record)
		<tr>

					<td>{{ $record->id }}</td>
					<td>{{$record->user?wordwrap($record->user->first_name, 10, "\n", true):'' }} {{$record->user?wordwrap($record->user->last_name, 10, "\n", true):'' }}</td>
					<td>{{$record->driver?wordwrap($record->driver->first_name, 10, "\n", true):'' }} </td>
					<td>{{ $record->pickup_address }}</td>
					<td>{{ $record->dest_address }}</td>
					<td>{{ $record->ride_cost }}</td>
					<td>{{ $record->car_type?$record->car_type:'' }}</td>
					<td>{{ $record->payment_type?$record->payment_type:'' }}
					</td>
					<td>
						@if($record->ride_type==1)
							Ride Schedule
						@elseif($record->ride_type==2)
							Ride Now
						@elseif($record->ride_type==3)
						 Instant Ride
						 @elseif($record->ride_type==4)
						  Ride Sharing
						@endif
					</td>
					<td>
						@if($record->status==-2)
						Cancelled
						@elseif($record->status==3)
						Completed
						@elseif($record->status==0)
						Pending
						@elseif($record->ride_time > date('Y-m-d H:i:s'))
							Upcoming
						@endif
						
					</td>
					<td class="">
						<div class="btn-group">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="dropdown-item" href="{{ url('admin/past-bookings-detail/'.$record->id) }}">View</a></li>
								<li><a href="{{ url('admin/booking/'.$record->id.'/user/') }}" class="dropdown-item">User Detail</a></li>

							</ul>
						</div>
					</td>
				</tr>
			@endforeach
				@if(count($array) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $array->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
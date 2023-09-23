<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="car_type" order="asc">
				<i class="fa fa-fw @if($orderby == 'car_type' && $order=='asc') fa-sort-asc @elseif($orderby == 'car_type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Car Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="price_per_km" order="asc">
				<i class="fa fa-fw @if($orderby == 'price_per_km' && $order=='asc') fa-sort-asc @elseif($orderby == 'price_per_km' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Price Per KM
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="basic_fee" order="asc">
				<i class="fa fa-fw @if($orderby == 'basic_fee' && $order=='asc') fa-sort-asc @elseif($orderby == 'basic_fee' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Basic Fee
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="alert_time" order="asc">
				<i class="fa fa-fw @if($orderby == 'alert_time' && $order=='asc') fa-sort-asc @elseif($orderby == 'alert_time' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Alert Time
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="seating_capacity" order="asc">
				<i class="fa fa-fw @if($orderby == 'seating_capacity' && $order=='asc') fa-sort-asc @elseif($orderby == 'seating_capacity' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Seating Capacity
			</th>
			
			<!--<th class="custom-userData-sort sort-th-sec" orderBy="seating_capacity" order="asc">
				<i class="fa fa-fw @if($orderby == 'seating_capacity' && $order=='asc') fa-sort-asc @elseif($orderby == 'seating_capacity' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Seating Capacity
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="pick_time_from" order="asc">
				<i class="fa fa-fw @if($orderby == 'pick_time_from' && $order=='asc') fa-sort-asc @elseif($orderby == 'pick_time_from' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Pick Time From
			</th> 
			<th class="custom-userData-sort sort-th-sec" orderBy="pick_time_to" order="asc">
				<i class="fa fa-fw @if($orderby == 'pick_time_to' && $order=='asc') fa-sort-asc @elseif($orderby == 'pick_time_to' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Pick Time To
			</th> 
			<th class="custom-userData-sort sort-th-sec" orderBy="night_charges" order="asc">
				<i class="fa fa-fw @if($orderby == 'night_charges' && $order=='asc') fa-sort-asc @elseif($orderby == 'night_charges' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Night Charges
			</th>-->
			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Mark As Default
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($vehicleTypes as $vehicleType)
				<tr>
					<td>{{ $vehicleType->id }}</td>
					<td>
					{{$vehicleType->car_type}}
					</td>
					<td>{{ $vehicleType->price_per_km }}</td>
					<td>{{ $vehicleType->basic_fee }}</td>
					<td>{{ $vehicleType->alert_time }}</td>
					<td>{{ $vehicleType->seating_capacity }}</td>
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_status" value="{{ $vehicleType->status }}" data-id="{{ $vehicleType->id }}" {{ $vehicleType->status === 1 ? "checked" : "" }}><span class="lever"></span>
							</label>
						</div>
					</td>
					<!--<td>{{ $vehicleType->seating_capacity }}</td>
					<td>{{ $vehicleType->pick_time_from }}</td>
					<td>{{ $vehicleType->pick_time_to }}</td>
					<td>{{ $vehicleType->night_charges }}</td>-->
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item" href="{{ route('vehicle-type.show',$vehicleType->id) }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item" href="{{ route('vehicle-type.edit',$vehicleType->id) }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $vehicleType->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($vehicleTypes) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $vehicleTypes->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
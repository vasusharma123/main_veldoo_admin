<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="category_id" order="asc">
				<i class="fa fa-fw @if($orderby == 'category_id' && $order=='asc') fa-sort-asc @elseif($orderby == 'category_id' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Car Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="year" order="asc">
				<i class="fa fa-fw @if($orderby == 'year' && $order=='asc') fa-sort-asc @elseif($orderby == 'year' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Year
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="model" order="asc">
				<i class="fa fa-fw @if($orderby == 'model' && $order=='asc') fa-sort-asc @elseif($orderby == 'model' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Model
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="color" order="asc">
				<i class="fa fa-fw @if($orderby == 'color' && $order=='asc') fa-sort-asc @elseif($orderby == 'color' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Color
			</th>
			<!---<th class="custom-userData-sort sort-th-sec" orderBy="driving_license" order="asc">
				<i class="fa fa-fw @if($orderby == 'driving_license' && $order=='asc') fa-sort-asc @elseif($orderby == 'driving_license' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Driving License
			</th>--->
			<th class="custom-userData-sort sort-th-sec" orderBy="vehicle_image" order="asc">
				<i class="fa fa-fw @if($orderby == 'vehicle_image' && $order=='asc') fa-sort-asc @elseif($orderby == 'vehicle_image' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Vehicle Image
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="vehicle_number_plate" order="asc">
				<i class="fa fa-fw @if($orderby == 'vehicle_number_plate' && $order=='asc') fa-sort-asc @elseif($orderby == 'vehicle_number_plate' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Vehicle Number Plate 
			</th>
			<!--<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>-->
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($vehicles as $vehicle)
				<tr>
					<td>{{ $vehicle->id }}</td>
					<td>{{ $vehicle->carType?$vehicle->carType->car_type:'' }}</td>
					<td>{{ $vehicle->year }}</td>
					<td>{{ $vehicle->model }}</td>
					<td>{{ $vehicle->color }}</td>
					<!-------<td>
					@if(!empty($vehicle->driving_license))
					<img src="{{ $vehicle->driving_license}}" height="50px" width="80px">
					@else
					<img src="{{url('public/no-images.png')}}" height="50px" width="80px">
					@endif
					</td>--->
					<td>
					@if(!empty($vehicle->vehicle_image))
					<img src="{{ $vehicle->vehicle_image }}" height="50px" width="80px">
					@else
					<img src="{{url('public/no-images.png')}}" height="50px" width="80px">
					@endif
					</td>
					<td>
					{{$vehicle->vehicle_number_plate}}
					</td>
					
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item" href="{{ route('vehicle.show',$vehicle->id) }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item" href="{{ route('vehicle.edit',$vehicle->id) }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $vehicle->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($vehicles) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $vehicles->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
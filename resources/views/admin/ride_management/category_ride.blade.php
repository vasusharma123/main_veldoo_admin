		<div class="row">
						<div class="col-md-6">
						<select name="ride_days" id="ride_days" class="form-control">
						<option value="">---Select Option---</option>
						<option value="day">Day</option>
						<option value="week">Week</option>
						<option value="month">Month</option>
						</select>
						<input type="hidden" name="id" id="id" value="{{$record->id}}">
						</div>
						<div class="col-md-6">
						<div class="hnd-form-cen-half-btn">
								<button class="filter_apply btn btn-primary" href="javascript:void(0);">{{trans('admin.Apply')}}</button>
							</div>
						</div>
						</div>
							<!--<div class="table-responsive" style="margin-top:20px">--->
							<table class="table table-bordered" style="margin-top:20px;">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="user_id" order="asc">
				<i class="fa fa-fw @if($orderby == 'user_id' && $order=='asc') -asc @elseif($orderby == 'user_id' && $order=='desc') -desc @else  @endif"></i>
				UserName
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="user_id" order="asc">
				<i class="fa fa-fw @if($orderby == 'user_id' && $order=='asc') -asc @elseif($orderby == 'user_id' && $order=='desc') -desc @else  @endif"></i>
				Driver Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="driver_id" order="asc">
				<i class="fa fa-fw @if($orderby == 'driver_id' && $order=='asc') -asc @elseif($orderby == 'driver_id' && $order=='desc') -desc @else  @endif"></i>
				Pickup Address
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="pickup_address" order="asc">
				<i class="fa fa-fw @if($orderby == 'pickup_address' && $order=='asc') -asc @elseif($orderby == 'pickup_address' && $order=='desc') -desc @else  @endif"></i>
				Destination Address
			</th>
		<th class="custom-userData-sort sort-th-sec" orderBy="price" order="asc">
				<i class="fa fa-fw @if($orderby == 'price' && $order=='asc') -asc @elseif($orderby == 'price' && $order=='desc') -desc @else  @endif"></i>
				Price
			</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="car_type" order="asc">
				<i class="fa fa-fw @if($orderby == 'car_type' && $order=='asc') -asc @elseif($orderby == 'car_type' && $order=='desc') -desc @else  @endif"></i>
			Car Type
			</th>
			</thead>
		<tbody>
			@foreach ($rides as $ride)
				<tr>
					<td>{{$ride?$ride->id:'' }}</td>
					<td>{{$ride->user?$ride->user->first_name:''}} {{$ride->user?$ride->user->last_name:''}}</td>
					<td>{{$ride->driver?$ride->driver['first_name']:''}} {{$ride->driver?$ride->driver['last_name']:''}}</td>
					<td>{{$ride->pickup_address?$ride->pickup_address:''}}</td>
					<td>{{$ride->dest_address?$ride->dest_address:''}}</td>
					<td>{{$ride->price?$ride->price:''}}</td>
					<td>{{$ride->category->name?$ride->category->name:''}}</td>
					</tr>
					@endforeach
					@if(count($rides) == 0)
					<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
		@endif
		</tbody>
	</table>
	{{ $rides->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
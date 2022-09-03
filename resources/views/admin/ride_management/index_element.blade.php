<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Driver Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Rider Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="pickup_address" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Pickup Address
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="dest_address" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Destination Address
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="price" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Price
				</th>
				<th class="custom-userData-sort sort-th-sec" orderBy="payment_type" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Payment Type
				</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($array as $record)
				<tr>
					<td>{{ $record->id }}</td>
					<td>{{$record->driver_first_name}} {{$record->driver_last_name}}</td>
					<td>{{$record->rider_first_name}} {{$record->rider_last_name}}</td>
					<td>{{$record->pickup_address}}</td>
					<td>{{$record->dest_address	}}</td>
					<td>{{$record->price}}</td>
					<td>
					@if(!empty($record->payment_type) && $record->payment_type	!=null)
					{{$record->payment_type	}}
					@endif
					</td>
					<td class="">
						<div class="btn-group">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="dropdown-item" href="{{ route($route.'.show',$record->id) }}">View</a></li>
								<!--<li><a class="dropdown-item" href="{{ route($route.'.edit',$record->id) }}">Edit</a></li>-->
								<li><a href="javascript:void(0);" class="dropdown-item delete_record" data-id="{{ $record->id }}">Delete</a></li>
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
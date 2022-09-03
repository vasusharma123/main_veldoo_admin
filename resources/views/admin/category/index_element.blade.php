<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($array as $record)
				<tr>
					<td>{{ $record->id }}</td>
					<td>{{ $record->name }}</td>
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_status" value="{{ $record->status }}" data-id="{{ $record->id }}" {{ $record->status === 1 ? "checked" : "" }}><span class="lever"></span>
							</label>
						</div>
					</td>
					<td class="">
						<div class="btn-group">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><a class="dropdown-item" href="{{ route($route.'.show',$record->id) }}">View</a></li>
								<li><a class="dropdown-item" href="{{ route($route.'.edit',$record->id) }}">Edit</a></li>
								<li><a href="javascript:void(0);" class="dropdown-item delete_record" data-id="{{ $record->id }}">Delete</a></li>
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
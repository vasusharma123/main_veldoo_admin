<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Name
			</th>
			
			<th class="custom-userData-sort sort-th-sec" orderBy="email" order="asc">
				<i class="fa fa-fw @if($orderby == 'email' && $order=='asc') fa-sort-asc @elseif($orderby == 'email' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Email
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="country_code" order="asc">
				<i class="fa fa-fw @if($orderby == 'country_code' && $order=='asc') fa-sort-asc @elseif($orderby == 'country_code' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Country code
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="phone" order="asc">
				<i class="fa fa-fw @if($orderby == 'phone' && $order=='asc') fa-sort-asc @elseif($orderby == 'phone' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Phone
			</th>
	

			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($companies as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->country_code }}</td>
					
					<td>{{ $user->phone }}</td>
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_status" value="{{ $user->status }}" data-id="{{ $user->id }}" {{ $user->status === 1 ? "checked" : "" }}><span class="lever"></span>
							</label>
						</div>
					</td>
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item" href="{{ route('company.show',$user->id) }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item" href="{{ route('company.edit',$user->id) }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $user->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($companies) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $companies->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				First Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="last_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'last_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'last_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Last Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="email" order="asc">
				<i class="fa fa-fw @if($orderby == 'email' && $order=='asc') fa-sort-asc @elseif($orderby == 'email' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Email
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="country_code" order="asc">
				<i class="fa fa-fw @if($orderby == 'country_code' && $order=='asc') fa-sort-asc @elseif($orderby == 'country_code' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Country Code
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="phone" order="asc">
				<i class="fa fa-fw @if($orderby == 'phone' && $order=='asc') fa-sort-asc @elseif($orderby == 'phone' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Phone
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="is_master" order="asc">
				<i class="fa fa-fw @if($orderby == 'is_master' && $order=='asc') fa-sort-asc @elseif($orderby == 'is_master' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Master Driver
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td><?php echo wordwrap($user->first_name, 25, '<br />', true)?></td>
					<td>{{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->country_code }}</td>
					<td>{{ $user->phone }}</td>
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_is_master" value="{{ $user->is_master }}" data-id="{{ $user->id }}" {{ $user->is_master === 1 ? "checked" : "" }}><span class="lever"></span>
							</label>
						</div>
					</td>	
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
								<a class="dropdown-item" href="{{ URL::to('/admin/driver/').'/'.$user->id }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item" href="{{ URL::to('/admin/driver/edit/').'/'.$user->id }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $user->id }}">{{ trans("admin.Delete") }}</a>
								<a class="dropdown-item" href="{{ url('admin/driver/'.$user->id.'/bookings') }}">{{ trans("admin.Bookings") }}</a>
						</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($users) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $users->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
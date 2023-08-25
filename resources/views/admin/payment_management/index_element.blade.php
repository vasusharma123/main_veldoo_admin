<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Fee
			</th>
			
			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($payment_managements as $payment_management)
				<tr>
					<td>{{ $payment_management->id }}</td>
					<td>{{ $payment_management->fee }}</td>
					
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_status" value="{{ $payment_management->status }}" data-id="{{ $payment_management->id }}" {{ $payment_management->status === 1 ? "checked" : "" }}><span class="lever"></span>
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
								<a class="dropdown-item" href="{{ URL::to('/admin/driver/').'/'.$payment_management->id }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item" href="{{ URL::to('/admin/driver/edit/').'/'.$payment_management->id }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $payment_management->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($payment_managements) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $payment_managements->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
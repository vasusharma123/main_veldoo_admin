<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw @if($orderby == 'name' && $order=='asc') fa-sort-asc @elseif($orderby == 'name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="status" order="asc">
				<i class="fa fa-fw @if($orderby == 'status' && $order=='asc') fa-sort-asc @elseif($orderby == 'status' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Status
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($payment_methods as $payment_method)
				<tr>
					<td>{{ $payment_method->id }}</td>
					<td>{{ $payment_method->name }}</td>
					
					<td>
						<div class="switch">
							<label>
								<input type="checkbox" class="change_status" value="{{ $payment_method->status }}" data-id="{{ $payment_method->id }}" {{ $payment_method->status === 1 ? "checked" : "" }}><span class="lever"></span>
							</label>
						</div>
					</td>
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="{{ route('payment-method.edit',$payment_method->id) }}">{{ trans("admin.Edit") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $payment_method->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($payment_methods) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $payment_methods->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="first_name" order="asc">
				<i class="fa fa-fw @if($orderby == 'first_name' && $order=='asc') fa-sort-asc @elseif($orderby == 'first_name' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Ride Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="title" order="asc">
				<i class="fa fa-fw @if($orderby == 'title' && $order=='asc') fa-sort-asc @elseif($orderby == 'title' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Title
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="message" order="asc">
				<i class="fa fa-fw @if($orderby == 'message' && $order=='asc') fa-sort-asc @elseif($orderby == 'message' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Message
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="mileage" order="asc">
				<i class="fa fa-fw @if($orderby == 'mileage' && $order=='asc') fa-sort-asc @elseif($orderby == 'mileage' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Mileage
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="start_date" order="asc">
				<i class="fa fa-fw @if($orderby == 'start_date' && $order=='asc') fa-sort-asc @elseif($orderby == 'start_date' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Start Date
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="end_date" order="asc">
				<i class="fa fa-fw @if($orderby == 'end_date' && $order=='asc') fa-sort-asc @elseif($orderby == 'end_date' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				End Date
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($vouchers as $voucher)
				<tr>
					<td>{{ $voucher->id }}</td>
					<td>{{ $voucher->first_name }} {{ $voucher->last_name}}</td>
					<td>{{ $voucher->title }}</td>
					<td>{{ $voucher->message }}</td>
					<td>{{ $voucher->mileage }}</td>
					<td>{{ $voucher->start_date }}</td>
					<td>{{ $voucher->end_date }}</td>
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item" href="{{ route('vouchers-offers.show',$voucher->id) }}">{{ trans("admin.View") }}</a>
								<a class="dropdown-item delete_record" data-id="{{ $voucher->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($vouchers) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $vouchers->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="title" order="asc">
				<i class="fa fa-fw @if($orderby == 'title' && $order=='asc') fa-sort-asc @elseif($orderby == 'title' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Title
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="type" order="asc">
				<i class="fa fa-fw @if($orderby == 'type' && $order=='asc') fa-sort-asc @elseif($orderby == 'type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="description" order="asc">
				<i class="fa fa-fw @if($orderby == 'description' && $order=='asc') fa-sort-asc @elseif($orderby == 'description' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Description
			</th>
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($notifications as $notification)
				<tr>
					<td>{{ $notification->id }}</td>
					<td>{{ $notification->title }}</td>
					<td>
					@if($notification->type==4)
						Important Alerts
					@elseif($notification->type==5)
						Promotional Offers
					@endif
					</td>
					<td>{{ $notification->description }}</td>
					
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item delete_record" data-id="{{ $notification->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($notifications) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $notifications->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
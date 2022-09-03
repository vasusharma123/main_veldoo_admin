<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="promotion" order="asc">
				<i class="fa fa-fw @if($orderby == 'promotion' && $order=='asc') fa-sort-asc @elseif($orderby == 'promotion' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Title
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="promotion" order="asc">
				<i class="fa fa-fw @if($orderby == 'promotion' && $order=='asc') fa-sort-asc @elseif($orderby == 'promotion' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Description
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="type" order="asc">
				<i class="fa fa-fw @if($orderby == 'type' && $order=='asc') fa-sort-asc @elseif($orderby == 'type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Image
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="type" order="asc">
				<i class="fa fa-fw @if($orderby == 'type' && $order=='asc') fa-sort-asc @elseif($orderby == 'type' && $order=='desc') fa-sort-desc @else fa-sort @endif"></i>
				Type
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
			@foreach ($promotion_offers as $promotion_offer)
				<tr>
					<td>{{ $promotion_offer->id }}</td>
					<td>{{ $promotion_offer->title }}</td>
					<td>{{ $promotion_offer->description }}</td>
					<td>
					{{ $promotion_offer->image }}					
					</td>
					<td>
					@if($promotion_offer->type == 1)
					All Users
				@else
					Specific User
				@endif
					
				</td>
					<td>{{ $promotion_offer->start_date }}</td>
					<td>{{ $promotion_offer->end_date }}</td>
					<td class="">
						<div class="btn-group dropright">
							<button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Action
							</button>
							<div class="dropdown-menu">
								<!-- Dropdown menu links -->
								<a class="dropdown-item delete_record" data-id="{{ $promotion_offer->id }}">{{ trans("admin.Delete") }}</a>
							</div>
						</div>
					</td>
				</tr>
			@endforeach
			@if(count($promotion_offers) == 0)
				<tr>
					<td class="text-center" colspan="6">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>
{{ $promotion_offers->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
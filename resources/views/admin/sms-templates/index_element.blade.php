<div class="table-responsive marginTbl">
	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th class="text-center">ID</th>
				<th>Template Name</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($records as $record)
			<tr>
				<td class="text-center">{{ $record->id }}</td>
				<td>{{ $record->title }}</td>
				
				<td class="actionbtns">
					<a href="{{ route('sms-template.edit', $record->id) }}" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
				</td>
			</tr>
			@endforeach
			@if(count($records) == 0)
				<tr>
					<td class="text-center" colspan="3">No Record Found</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $records->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
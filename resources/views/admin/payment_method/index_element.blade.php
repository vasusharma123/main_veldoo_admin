<div class="table-responsive marginTbl">

	<table class="table table-borderless table-fixed customTable">
		<thead>
			<tr>
				<th class="text-center">ID</th>
				<th>Name</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
		@foreach ($records as $record)
			<tr>
				<td class="text-center">{{ $record->id }}</td>
				<td>{{ $record->name }}</td>
				<td class="switch_btn">
						<label class="switch">
							<input type="checkbox" class="change_status" value="{{ $record->status }}" data-id="{{ $record->id }}" {{ $record->status == 1 ? "checked" : "" }}>
							<span class="slider round"></span>
						</label>
					</td>
				<td class="actionbtns">
					<a href="{{ route('payment-method.edit',$record->id) }}" class="actionbtnsLinks"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
					<a href="javascript:void(0);" class="actionbtnsLinks delete_method" data-id="{{ $record->id }}"><img src="{{ asset('assets/images/veldoo/deleteBox.png') }}" class="img-fluid tableIconsbtns delete_btn" alt="delete_btn"></a>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
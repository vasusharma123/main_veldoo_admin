<div class="table-responsive">
	<table class="table table-bordered">
		<thead class="thead-light">
			<th>{{trans('admin.ID')}}</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Name
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Ride Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Complaint Type
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Message
			</th>
			<th class="custom-userData-sort sort-th-sec" orderBy="name" order="asc">
				<i class="fa fa-fw fa-sort"></i>
				Complaint Date
			</th>
			
			<th>Action</th>
		</thead>
		<tbody>
			@foreach ($array as $record)
				<tr>
					<td>{{ $record->id }}</td>
					<td>{{ $record->first_name}} {{ $record->last_name}}</td>
					<td>{{ $record->name }}</td>
					<td>{{ $record->title }}</td>
					<td><?php echo wordwrap($record->message,15,"<br>\n");?></td>
					<td>{{ $record->created_at->format('d-m-Y H:i:s') }}</td>
					<td class="">
						<div class="btn-group">
							<button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#exampleModalCenter" data-id="{{$record->user_id}}" id="reply_button">
							 Reply
							</button>
							
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

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Reply To User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div id="success_message"></div>
      <div class="modal-body">
      <form method="post" action="" id="reply_form"> 
	  @csrf
	  <div class="form-group">
		<?php
			echo Form::label('message', 'Message',['class'=>'control-label']);
			echo Form::textarea('message',null,['class'=>'form-control ckeditor','required'=>true,'style'=>'width:99.8%;','id'=>'message']);
		?>
		</div>
		<input type="hidden" name="user_id" id="user_id" value="">
	  </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-modal-btn">Close</button>
        <button type="button" class="btn btn-primary" id="formSubmit">Send</button>
      </div>
    </div>
  </div>
</div>
{{ $array->appends(Request::all())->links('vendor.pagination.bootstrap-4') }}
@extends('admin.layouts.master')

@section('content')
<main class="body_content">
	<div class="inside_body">
		<div class="container-fluid p-0">
			<div class="row m-0 w-100">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 p-0">
					<div class="body_flow">
						@include('admin.layouts.sidebar')
						<div class="formTableContent">
							<section class="addEditForm sectionsform bg-transparent">
								@include('admin.layouts.flash-message')
								<article class="container-fluid">
									{{ Form::model($record, ['url' => route('users.settingsUpdate'), 'class' => 'custom_form editForm', 'id' => 'EditUser', 'enctype' => 'multipart/form-data']) }}
									@method('PATCH')
										<div class="table_boxes" id="countrySetting">
											<h2 class="table_header">Country settings</h2>
											<table class="table table-borderless table-fixed customTable longTbl">
												<thead>
													<tr>
														<th class="text-center" style="width: 70px;">ID</th>
														<th>Country settings</th>
														<th>Parametar</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-center">1</td>
														<td>Curency symbol</td>
														<td>
															<div class="text-curreny-symbol">{{ (!empty($record->currency_symbol) ? $record->currency_symbol : '') }}</div>
															<?php echo Form::text('currency_symbol', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Curency symbol']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-curreny-symbol" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr>
														<td class="text-center">2</td>
														<td>Curency Name</td>
														<td>
															<div class="text-curreny-name">{{ (!empty($record->currency_name) ? $record->currency_name : '') }}</div>
															<?php echo Form::text('currency_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Curency Name']); ?>
														</td>
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-curreny-name" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
												</tbody>
											</table>
										</div>

										<div class="table_boxes" id="generalSetting">
											<h2 class="table_header">General settings</h2>
											<table class="table table-borderless table-fixed customTable longTbl">
												<thead>
													<tr>
														<th class="text-center" style="width: 70px;">ID</th>
														<th>Name</th>
														<th>Parametar</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<!--<tr>
														<td class="text-center">1</td>
														<td>Voucher km per ride</td>
														<td>
															<div class="text-kmper-ride">10</div>
															<?php //echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Voucher km per ride']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-kmper-ride" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr>
														<td class="text-center">2</td>
														<td>Voucher km per invitation</td>
														<td>
															<div class="text-kmper-invitation">15</div>
															<?php //echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Voucher km per invitation']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-kmper-invitation" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>-->
													<tr>
														<td class="text-center">3</td>
														<td>Notification</td>
														<td></td>
														
														<td class="actionbtns">
															<div class="switch_btn">
																<label class="switch">
																	<input type="checkbox" name="notification" value="1" {{ $record->notification == 1 ? 'checked' : '' }}>
																	<span class="slider round whitegrey_btn"></span>
																</label>
															</div>
														</td>
													</tr>
													<tr>
														<td class="text-center">4</td>
														<td>Delete only phone number users (in days)</td>
														<td>
															<div class="text-delete-users">{{ (!empty($record->temporary_phone_number_users) ? $record->temporary_phone_number_users : '') }}</div>
															<?php echo Form::text('temporary_phone_number_users', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Delete only phone number users (in days)']); ?>
														</td>
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-delete-users" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">User from driver app by the phone number, will delete in n days</td>
													</tr>
													<tr>
														<td class="text-center">5</td>
														<td>Delete only last name users (In days)</td>
														<td>
															<div class="text-delete-lastusers">{{ (!empty($record->temporary_last_name_users) ? $record->temporary_last_name_users : '') }}</div>
															<?php echo Form::text('temporary_last_name_users', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Delete only last name users (In days)']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-delete-lastusers" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">User from driver app by last name, will delete in n days</td>
													</tr>
												</tbody>
											</table>
										</div>

										<!--<div class="table_boxes" id="RideSetting">
											<h2 class="table_header">Ride settings</h2>
											<table class="table table-borderless table-fixed customTable longTbl">
												<thead>
													<tr>
														<th class="text-center" style="width: 70px;">ID</th>
														<th>Name</th>
														<th>Parametar</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-center">1</td>
														<td>Driver requests</td>
														<td>
															<div class="text-driver-req">15</div>
															<?php echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Driver requests']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-driver-req" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">Send request to defined number of drivers</td>
													</tr>
													<tr>
														<td class="text-center">2</td>
														<td>Waiting time</td>
														<td>
															<div class="text-waiting-time">15</div>
															<?php echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Waiting time']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-waiting-time" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">Driver will have time to accept Request(In seconds)</td>
													</tr>
													<tr>
														<td class="text-center">3</td>
														<td>Notification</td>
														<td></td>
														
														<td class="actionbtns">
															<div class="switch_btn">
																<label class="switch">
																	<input type="checkbox">
																	<span class="slider round whitegrey_btn"></span>
																</label>
															</div>
														</td>
													</tr>
													<tr>
														<td class="text-center">4</td>
														<td>Delete only phone number users (in days)</td>
														<td>
															<div class="text-delete-rideusers">15</div>
															<?php echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Delete only phone number users']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-delete-rideusers" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">User from driver app by the phone number, will delete in n days</td>
													</tr>
													<tr>
														<td class="text-center">5</td>
														<td>Delete only last name users (In days)</td>
														<td>
															<div class="text-delete-ridelastusers">15</div>
															<?php echo Form::text('site_name', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Delete only phone number users']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-delete-ridelastusers" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">User from driver app by last name, will delete in n days</td>
													</tr>
												</tbody>
											</table>
										</div>-->

										<div class="table_boxes" id="RideSetting2">
											<h2 class="table_header">Ride settings</h2>
											<table class="table table-borderless table-fixed customTable longTbl">
												<thead>
													<tr>
														<th class="text-center" style="width: 70px;">ID</th>
														<th>Name</th>
														<th>Parametar</th>
														<th class="text-center">Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td class="text-center">1</td>
														<td>Driver requests</td>
														<td>
															<div class="text-delete-ridelastusers-2">{{ (!empty($record->driver_requests) ? $record->driver_requests : '') }}</div>
															<?php echo Form::text('driver_requests', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Driver requests']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-delete-ridelastusers-2" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">Send request to defined number of drivers</td>
													</tr>
													<tr>
														<td class="text-center">2</td>
														<td>Waiting time</td>
														<td>
															<div class="text-waiting-time-2">{{ (!empty($record->waiting_time) ? $record->waiting_time : '') }}</div>
															<?php echo Form::text('waiting_time', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Waiting time']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-waiting-time-2" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">Driver will have time to accept Request(In seconds)</td>
													</tr>
													
													<tr>
														<td class="text-center">3</td>
														<td>Radius</td>
														<td>
															<div class="text-radius">{{ (!empty($record->radius) ? $record->radius : '') }}</div>
															<?php echo Form::text('radius', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Radius']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-radius" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">Driver will search in this radius (in km)</td>
													</tr>

													<tr>
														<td class="text-center">4</td>
														<td>Radius for join rides (in km)</td>
														<td>
															<div class="text-radius-join">{{ (!empty($record->join_radius) ? $record->join_radius : '') }}</div>
															<?php echo Form::text('join_radius', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Radius for join']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-radius-join" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">User will see join rides in this radius (in km)</td>
													</tr>

													<tr>
														<td class="text-center">5</td>
														<td>Driver Idle Time (In minutes)</td>
														<td>
															<div class="text-driver-idle">{{ (!empty($record->driver_idle_time) ? $record->driver_idle_time : '') }}</div>
															<?php echo Form::text('driver_idle_time', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Driver Idle Time']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-driver-idle" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">After n minutes of staying idle, the driver receives a notification alert</td>
													</tr>

													<tr>
														<td class="text-center">6</td>
														<td>Current ride distance addition (in km)</td>
														<td>
															<div class="text-current-ride">{{ (!empty($record->current_ride_distance_addition) ? $record->current_ride_distance_addition : '') }}</div>
															<?php echo Form::text('current_ride_distance_addition', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Current ride distance']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-current-ride" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">While searching for driver, up to the n miles</td>
													</tr>
													<tr>
														<td class="text-center">7</td>
														<td>Waiting ride distance addition (in km)</td>
														<td>
															<div class="text-waiting-ride">{{ (!empty($record->waiting_ride_distance_addition) ? $record->waiting_ride_distance_addition : '') }}</div>
															<?php echo Form::text('waiting_ride_distance_addition', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Waiting ride distance']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-waiting-ride" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
													<tr class="hintrow">
														<td class="hinttext"></td>
														<td colspan="3" class="hinttext">If ride have no destination location of waiting ride than add n miles</td>
													</tr>

													<tr>
														<td class="text-center">8</td>
														<td>Driver count to display</td>
														<td>
															<div class="text-driver-count">{{ (!empty($record->driver_count_to_display) ? $record->driver_count_to_display : '') }}</div>
															<?php echo Form::text('driver_count_to_display', null, ['class' => 'form-control inputText"', 'required' => true, 'style' => 'display:none', 'placeholder' => 'Driver count to display']); ?>
														</td>
														
														<td class="actionbtns">
															<a href="javascript:void(0);" data-class="text-driver-count" class="actionbtnsLinks settings-data-edit-click"><img src="{{ asset('assets/images/veldoo/editpen.png') }}" class="img-fluid tableIconsbtns edit_btn" alt="edit"></a>
														</td>
													</tr>
												</tbody>
											</table>

											<div class="action_btns_main">
												<div class="btns_forms d-flex align-items-center">
													<button style="opacity: 0;pointer-events:none;" class="form-control submit_btn mt-2 greyBtns" type="button">Default</button>
													<button class="form-control submit_btn mt-2 ms-2" type="submit">Save</button>
												</div>
											</div>
										</div>
									{{ Form::close() }}
								</article>
							</section>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</main>
@endsection	

@section('footer_scripts')
<script type="text/javascript">
$(document).ready(function(){
	
	$('body').on('click', '.settings-data-edit-click', function(){
		var classname = $(this).attr('data-class');
		$('.'+classname).hide();
		$('.'+classname).next().show();
	});
});
</script>
@stop
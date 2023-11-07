@if (!empty($ride_detail->creator->first_name))
<h2 class="board_title booking">Created By</h2>
<div class="userBox mb-3">
    <div class="avatarImg_diver position-relative">
        @if (!empty($ride_detail->creator->image))
        <img src="{{ url('storage/' . $ride_detail->creator->image) }}" alt="Created By" class="img-fluid DriverImage rounded-circle">
        @else
        <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" alt="Driver" class="img-fluid DriverImage rounded-circle">
        @endif
    </div>
    <div class="user_name">
        <h4 class="name active_driverImage">{{ $ride_detail->creator->full_name ?? '' }}</h4>
        <p class="number">
            @if($ride_detail->creator->user_type == 4)
            (Admin)
            @elseif($ride_detail->creator->user_type == 5)
            (Manager)
            @endif
        </p>
    </div>
</div>
@endif


<h2 class="board_title booking">Driver Details</h2>
@if ($ride_detail->status == -2)
<p class="infomation_update done bg-danger">Cancelled</p>
@elseif($ride_detail->status == -1)
<p class="infomation_update done bg-danger">Rejected</p>
@elseif($ride_detail->status == 1)
<p class="infomation_update done bg-info">Accepted</p>
@elseif($ride_detail->status == 2)
<p class="infomation_update done bg-info">Started</p>
@elseif($ride_detail->status == 4)
<p class="infomation_update done bg-info">Driver Reached</p>
@elseif($ride_detail->status == 3)
<p class="infomation_update done">Completed</p>
@elseif($ride_detail->status == -3)
<p class="infomation_update done bg-danger">Cancelled by you</p>
@elseif($ride_detail->status == 0)
<p class="infomation_update done bg-warning">Pending</p>
@elseif($ride_detail->ride_time > date('Y-m-d H:i:s'))
<p class="infomation_update done bg-warning">Upcoming</p>
@endif
@if (!empty($ride_detail->driver->phone))
<div class="userBox mt-3">
    <div class="avatarImg_diver position-relative">
        @if (!empty($ride_detail->driver->image))
        <img src="{{ url('storage/' . $ride_detail->driver->image) }}" alt="Driver" class="img-fluid DriverImage rounded-circle">
        @else
        <img src="{{ asset('company/assets/imgs/sideBarIcon/accounts.png') }}" alt="Driver" class="img-fluid DriverImage rounded-circle">
        @endif
        @if ($ride_detail->driver->is_available)
        <span class="driver_status online"></span>
        @endif
    </div>
    <div class="user_name">
        <h4 class="name active_driverImage">{{ $ride_detail->driver->full_name ?? '' }}</h4>
        <p class="number">{{ '+' . $ride_detail->driver->country_code . $ride_detail->driver->phone }}</p>
    </div>
</div>
@endif
@if (!empty($ride_detail->vehicle->model))
<div class="userBox mt-3">
    <div class="avatarImg_diver">
        @if (!empty($ride_detail->vehicle->vehicle_image))
        <img src="{{ env('URL_PUBLIC') . '/' . $ride_detail->vehicle->vehicle_image }}" alt="car" class="img-fluid DriverImage ">
        @else
        <img src="{{ asset('company/assets/imgs/sideBarIcon/redcar.png') }}" alt="car" class="img-fluid DriverImage ">
        @endif
    </div>
    <div class="user_name">
        <h4 class="name active_driverImage">{{ $ride_detail->vehicle->model ?? '' }}</h4>
        <p class="number">{{ $ride_detail->vehicle->vehicle_number_plate ?? '' }}</p>
    </div>
</div>
@endif

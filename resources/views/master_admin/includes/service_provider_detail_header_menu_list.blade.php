<li class="nav-item">
    <a class="nav-link <?php if($action == 'current_plan') { echo "active";  }  ?>" href="{{ route('service-provider.current_plan',['id' => request('id')])}}">Plan</a>
</li>
<li class="nav-item">
    <a class="nav-link <?php if($action == 'profile_detail' ) { echo "active";  } ?>" href="{{ route('service-provider.profile-detail',['id' => request('id')])}}">Details</a>
</li>
<li class="nav-item">
    <a class="nav-link <?php if($action == 'billing_detail') { echo "active";  } ?>" href="{{ route('service-provider.billing_detail',['id' => request('id')])}}">Billing</a>
</li>
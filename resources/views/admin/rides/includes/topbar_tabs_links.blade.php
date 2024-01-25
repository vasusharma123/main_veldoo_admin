<li class="nav-item" role="presentation">
    <a href="{{ route('rides.list') }}" class="nav-link {{($action=="list")?'active':''}}" id="listVise">List View</a>
</li>
<li class="nav-item" role="presentation">
    <a href="{{ route('rides.month') }}" class="nav-link {{($action=="month")?'active':''}}" id="monthVise">Month View</a>
</li>
<li class="nav-item" role="presentation">
    <a href="{{ route('rides.week') }}" class="nav-link {{($action=="week")?'active':''}}" id="weekVise">Week View</a>
</li>
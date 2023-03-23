<h1>Welcome Mail</h1>
  
Service Provider login details:
URL : <a href="{{ route('adminLogin') }}">{{ route('adminLogin') }}</a>
Email : {{ $data['serviceProvider']['email'] }}
Password : {{ $data['password'] }}
<br>
<br>
Driver login details:
Email : {{ $data['driver']['country_code'] }}-{{ $data['driver']['phone'] }}
Password : {{ $data['password'] }}
<br>
<br>
Customer login details:
Email : {{ $data['driver']['country_code'] }}-{{ $data['driver']['phone'] }}
Password : {{ $data['password'] }}
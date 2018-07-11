@php $route = Route::current()->getName() @endphp
<li @if($route=='home')class="active"@endif>
    <a href="{{route('home')}}">
        <i class="material-icons">home</i>
        <span>Home</span>
    </a>
</li>
<li @if(explode(".",str_replace("student.", "", $route))[0] == "presence")class="active"@endif>
    <a href="{{route('student.presence.list')}}">
        <i class="material-icons">fingerprint</i>
        <span>Presence</span>
    </a>
</li> 
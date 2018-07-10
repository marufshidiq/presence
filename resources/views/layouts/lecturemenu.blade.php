@php $route = Route::current()->getName() @endphp
<li @if($route=='home')class="active"@endif>
    <a href="{{route('home')}}">
        <i class="material-icons">home</i>
        <span>Home</span>
    </a>
</li>
<li @if(explode(".",str_replace("lecture.", "", $route))[0] == "class")class="active"@endif>
    <a href="{{route('lecture.class.list')}}">
        <i class="material-icons">account_balance</i>
        <span>Class</span>
    </a>
</li> 
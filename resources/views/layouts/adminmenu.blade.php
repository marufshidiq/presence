@php $route = Route::current()->getName() @endphp
<li @if($route=='home')class="active"@endif>
    <a href="{{route('home')}}">
        <i class="material-icons">home</i>
        <span>Home</span>
    </a>
</li>
<li @if(explode(".",$route)[0] == "student")class="active"@endif>
    <a href="{{route('student.list')}}">
        <i class="material-icons">person_outline</i>
        <span>Student</span>
    </a>
</li>
<li @if(explode(".",$route)[0] == "lecture")class="active"@endif>
    <a href="{{route('lecture.list')}}">
        <i class="material-icons">person</i>
        <span>Lecture</span>
    </a>
</li>
<li @if($route=='room.show')class="active"@endif>
    <a href="{{route('room.show')}}">
        <i class="material-icons">domain</i>
        <span>Room</span>
    </a>
</li>
<li @if($route=='card.list')class="active"@endif>
    <a href="{{route('card.list')}}">
        <i class="material-icons">contact_mail</i>
        <span>Card</span>
    </a>
</li>
<li @if($route=='curriculum.list')class="active"@endif>
    <a href="{{route('curriculum.list')}}">
        <i class="material-icons">school</i>
        <span>Curriculum</span>
    </a>
</li>
<li @if($route=='period.list')class="active"@endif>
    <a href="{{route('period.list')}}">
        <i class="material-icons">event_note</i>
        <span>Period</span>
    </a>
</li>
<li @if(explode(".",$route)[0] == "course") class="active" @endif>
    <a href="{{route('course.list')}}">
        <i class="material-icons">library_books</i>
        <span>Course</span>
    </a>
</li>
<li @if(explode(".",$route)[0] == "class")class="active"@endif>
    <a href="{{route('class.list')}}">
        <i class="material-icons">account_balance</i>
        <span>Class</span>
    </a>
</li> 
<li @if(explode(".",$route)[0] == "presence")class="active"@endif>
    <a href="{{route('presence.list')}}">
        <i class="material-icons">fingerprint</i>
        <span>Presence</span>
    </a>
</li>
<li @if($route=='log.list')class="active"@endif>
    <a href="{{route('log.list')}}">
        <i class="material-icons">restore</i>
        <span>Log</span>
    </a>
</li>
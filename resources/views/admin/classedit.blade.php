@extends('layouts.app')

@section('title', 'Class Manager - ')

@section('css')
<link href="{{asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">            
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT NEW CLASS                                
                            </h2>                            
                        </div>
                        <div class="body">                                                        
                            <div class="row clearfix">
                                <form action="{{route('class.edit')}}" id="class-add" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$class['id']}}">
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class Name</h4>
                                        <input type="text" class="form-control inp" value="{{$class['name']}}" name="name" id="name" required>                                                                                        
                                    </div> 
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Period</h4>
                                        <select class="form-control show-tick inp" name="period" id="period">
                                            @foreach(\App\Period::all() as $data)
                                            <option @if($data['id']==$class['periode_id']) selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                                                                                           
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Course</h4>
                                        <select class="form-control show-tick inp" name="course" id="course">
                                            @foreach(\App\Course::all() as $data)
                                            <option @if($data['id']==$class['course_id']) selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Lecture</h4>
                                        <select class="form-control show-tick inp" name="lecture" id="lecture">
                                            @foreach(\App\User::where('role', 'lecturer')->get() as $data)
                                            <option @if($data['id']==$class['lecture_id']) selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Room</h4>
                                        <select class="form-control show-tick inp" name="room" id="room">
                                            @foreach(\App\Room::all() as $data)
                                            <option @if($data['id']==$class['room_id']) selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                                                      
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Day</h4>
                                        <select class="form-control show-tick inp" name="day" id="day">
                                            @foreach(["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"] as $data)
                                            <option @if($loop->index==$class['day']) selected @endif value="{{$loop->index}}">{{$data}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6" style="margin-bottom:20px;">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class Begin</h4>
                                        <input type="text" class="timepicker form-control inp" name="start" id="start" value="{{$class['start']}}" required>                                                                                        
                                    </div>
                                    <div class="col-sm-6" style="margin-bottom:20px;">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class End</h4>
                                        <input type="text" class="timepicker form-control inp" name="end" id="end" value="{{$class['end']}}" required>                                                                                        
                                    </div>                                    
                                    <div class="col-sm-12">                                        
                                        <button type="button" onclick="checkSchedule()" style="margin-bottom: 12px;" class="btn btn-info btn-lg m-l-15 waves-effect che">CHECK SCHEDULE</button>
                                        <button type="submit" style="margin-bottom: 12px; display:none;" id="btn-submit" class="btn btn-success btn-lg m-l-15 waves-effect sub">UPDATE</button>
                                        <button type="button" onclick="cancelEdit()" style="display:none;margin-bottom: 12px;" class="btn btn-warning btn-lg m-l-15 waves-effect sub">CANCEL</button>
                                    </div>
                                </form>                                                                
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Input -->                                  
        </div>
    </section>
@ensection

@section('js')
<script src="{{asset('plugins/momentjs/moment.js') }}"></script>
<script src="{{asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script type="text/javascript">    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.timepicker').bootstrapMaterialDatePicker({
        format: 'HH:mm:00',            
        date: false
    });

    $('#class-add').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) { 
            e.preventDefault();
            return false;
        }
    });

    $('#btn-submit').click(function(){
        $('.inp').attr('disabled', false);
    });

    function cancelEdit(){
        $('.inp').attr('disabled', false);
        $('.sub').hide();
        $('.che').show();
    }

    function checkSchedule(){
        var vName = $('#name').val();
        var vPeriod = $('#period option:selected').val();        
        var vRoom = $('#room option:selected').val();
        var vDay = $('#day option:selected').val();        
        var vStart = $('#start').val();
        var vEnd = $('#end').val();        
        console.log(vPeriod, vRoom, vDay, vStart, vEnd);
        if(vName.length==0){
            alert("Please fill out 'Class Name' field");
            $('#name').focus();
        }
        else if(vStart > vEnd){
            alert("Please set the Class Begin before the Class End");
        }
        else {
            $.ajax({
                type:'POST',
                url:'{{route('class.check')}}',
                data:{
                    period: vPeriod,
                    room: vRoom,
                    day: vDay,
                    start: vStart,
                    end: vEnd
                },
                success:function(data){
                    $('.inp').attr('disabled', true);
                    $('.che').hide();
                    $('.sub').show();
                },
                error:function(data){                    
                    alert("Room is used by other class, please choose other room or other time");
                }
            });            
        }
    }

    function deleteClass($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
            
        }
    }
</script>
@endsection
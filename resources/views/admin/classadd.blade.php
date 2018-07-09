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
                                ADD NEW CLASS                                
                            </h2>                            
                        </div>
                        <div class="body">                                                        
                            <div class="row clearfix">
                                <form action="{{route('class.add')}}" method="POST">
                                    {{ csrf_field() }}
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class Name</h4>
                                        <input type="text" class="form-control" name="name" id="name" required>                                                                                        
                                    </div> 
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Period</h4>
                                        <select class="form-control show-tick" name="period">
                                            @foreach(\App\Period::all() as $data)
                                            <option @if($data['status']=="1") selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                                                                                           
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Course</h4>
                                        <select class="form-control show-tick" name="course">
                                            @foreach(\App\Course::all() as $data)
                                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Lecture</h4>
                                        <select class="form-control show-tick" name="lecture">
                                            @foreach(\App\User::where('role', 'lecturer')->get() as $data)
                                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Room</h4>
                                        <select class="form-control show-tick" name="room">
                                            @foreach(\App\Room::all() as $data)
                                            <option value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>                                                                      
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Day</h4>
                                        <select class="form-control show-tick" name="day">
                                            @foreach(["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"] as $data)
                                            <option value="{{$loop->index}}">{{$data}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6" style="margin-bottom:20px;">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class Begin</h4>
                                        <input type="text" class="timepicker form-control" name="start" id="start" value="14:00:00" required>                                                                                        
                                    </div>
                                    <div class="col-sm-6" style="margin-bottom:20px;">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Class End</h4>
                                        <input type="text" class="timepicker form-control" name="end" id="end" value="14:00:00" required>                                                                                        
                                    </div>                                    
                                    <div class="col-sm-12">                                        
                                        <button type="submit" style="margin-bottom: 12px;" class="btn btn-success btn-lg m-l-15 waves-effect">ADD</button>
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
        $('.timepicker').bootstrapMaterialDatePicker({
            format: 'HH:mm:00',            
            date: false
        });    
</script>
@endsection
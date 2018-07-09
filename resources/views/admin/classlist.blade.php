@extends('layouts.app')

@section('title', 'Class Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Class Manager</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <div class="content">
                            <div class="text">Class</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Classes::all()->count()}}" data-speed="10" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                       
            <div class="row clearfix">                                                                                    
                <button onclick="location.href='{{ route('class.add.form') }}'" style="margin-bottom: 12px;" class="btn btn-success btn-lg m-l-15 waves-effect">ADD NEW CLASS</button>                                
            </div>
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>List</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Period</th>
                                            <th>Name</th>
                                            <th>Course</th>
                                            <th>Lecture</th>
                                            <th>Room</th>
                                            <th>Schedule</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Classes::all() as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->period['name'] }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>{{ $data->course['name'] }}</td>
                                            <td>{{ $data->lecture['name'] }}</td>
                                            <td>{{ $data->room['name'] }}</td>
                                            <td>{{ $data->the_day() }} {{ $data->class_start() }} - {{ $data->class_end() }}</td>
                                            <td>
                                                <button class="btn btn-info waves-effect">Student</button>                                                                                                    
                                                <button onclick="location.href='{{ route('class.edit.form', ['id'=>$data['id']]) }}'" class="btn btn-warning waves-effect">Edit</button>
                                                <button onclick="deleteClass({{$data['id']}})" class="btn btn-danger waves-effect">Delete</button>
                                            </td>                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->                
            </div>
            
        </div>
    </section>
@endsection

@section('js')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    function deleteClass($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
            $.ajax({
                type:'POST',
                url:'{{route('class.delete')}}',
                data:{
                    id: $id
                },
                success:function(data){
                    location.reload();
                }
            });
        }
    }
</script>
@endsection
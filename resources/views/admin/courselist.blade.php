@extends('layouts.app')

@section('title', 'Course Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Course Manager</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">library_books</i>
                        </div>
                        <div class="content">
                            <div class="text">Course</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Course::all()->count()}}" data-speed="10" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                       
            <div class="row clearfix">                                                                                    
                <button onclick="location.href='{{ route('course.add.form') }}'" style="margin-bottom: 12px;" class="btn btn-success btn-lg m-l-15 waves-effect">ADD NEW COURSE</button>                                
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
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>SKS</th>
                                            <th>Category</th>
                                            <th>Group</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Course::all() as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data['code'] }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>{{ $data['sks'] }}</td>
                                            <td>{{ $data['category'] }}</td>
                                            <td>{{ $data['group'] }}</td>
                                            <td>                                                                                                    
                                                <button onclick="location.href='{{ route('course.edit.form', ['id'=>$data['id']]) }}'" class="btn btn-warning waves-effect">Edit</button>
                                                <button onclick="deleteCourse({{$data['id']}})" class="btn btn-danger waves-effect">Delete</button>
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
    
    function deleteCourse($id){
        console.log($id);
        $.ajax({
            type:'POST',
            url:'{{route('course.delete')}}',
            data:{
                id: $id
            },
            success:function(data){
                location.reload();
            }
        });
    }
</script>
@endsection
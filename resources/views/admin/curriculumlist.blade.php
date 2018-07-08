@extends('layouts.app')

@section('title', 'Curriculum Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Curriculum Manager</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">school</i>
                        </div>
                        <div class="content">
                            <div class="text">Curriculum</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Curriculum::all()->count()}}" data-speed="10" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                       
            <div class="row clearfix">
                <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">
                    <div class="card"> 
                        <div class="header">
                            <h2>
                                ADD NEW CURRICULUM                                
                            </h2>
                        </div>                       
                        <div class="body">
                            <form method="POST" action="{{route('curriculum.add')}}" id="curriculum-form">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="curriculum-name" name="name" required>
                                                <label class="form-label">Curriculum Name</label>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="submit" id="btn-form" class="btn btn-success btn-lg m-l-15 waves-effect">ADD</button>
                                        <button onclick="switchAdd()" type="button" id="btn-cancel" class="btn btn-warning btn-lg m-l-15 waves-effect">CANCEL</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Curriculum::all() as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>@if($data['status'] == "1") Active @endif</td>
                                            <td>
                                                <button type="button" class="btn btn-default waves-effect show-course" data-id="{{$data['id']}}" data-toggle="modal" data-target="#courseModal">Show Course</button>
                                                <button @if($data['status'] == "1") disabled @endif onclick="defaultCurriculum({{$data['id']}})" class="btn btn-info waves-effect">Set Default</button>
                                                <button onclick="switchEdit({{$data['id']}}, '{{$data['name']}}')" class="btn btn-warning waves-effect">Edit</button>                                                
                                                <button onclick="deleteCurriculum({{$data['id']}})" class="btn btn-danger waves-effect">Delete</button>
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
            <div class="modal fade" id="courseModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="courseModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-course-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Curriculum</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>SKS</th>
                                            <th>Category</th>
                                            <th>Group</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                                                               
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">                            
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script type="text/javascript">
    $( document ).ready(function() {
        $('#btn-cancel').hide();
    });

    $(".show-course").click(function(){
        console.log($(this).data('id'));
        console.log("Diklik");
        showCourse($(this).data('id'));
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showCourse($id){
        $.ajax({
            type:'POST',
            url:'{{route('curriculum.showcourse')}}',
            data:{
                id: $id
            },
            success:function(data){                
                console.log(data);
                // var d = JSON.parse(data);
                $('#courseModalLabel').html(data.name);
                $("table.dashboard-course-infos tbody").empty();
                
                if(data.course.length == 0){                    
                    $('.modal-body .table-responsive').hide();
                }
                else {
                    $('.modal-body .table-responsive').show();
                    $.each(data.course, function(key, value) {
                        var tr = $("<tr />")
                        $.each(value, function(k, v) {
                            tr.append(
                                $("<td />", {
                                html: v
                                })[0].outerHTML
                            );
                            $("table.dashboard-course-infos tbody").append(tr);
                        })
                    });
                }
            }
        });
    }
    
    function drawTable(data) {
        for (var i = 0; i < data.length; i++) {
            drawRow(data[i]);
        }
    }

    function drawRow(rowData) {
        var row = $("<tr />")
        $("#personDataTable").append(row);
        row.append($("<td>" + rowData.id + "</td>"));
        row.append($("<td>" + rowData.firstName + "</td>"));
        row.append($("<td>" + rowData.lastName + "</td>"));
    }

    function deleteCourse($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
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
    }
    
    function deleteCurriculum($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
            $.ajax({
                type:'POST',
                url:'{{route('curriculum.delete')}}',
                data:{
                    id: $id
                },
                success:function(data){
                    location.reload();
                },
                error:function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR.responseText);
                    var err = JSON.parse(jqXHR.responseText);
                    alert(err.error);
                    // handleError(errorThrown);
                }
            });
        }
    }

    function defaultCurriculum($id){
        console.log($id);
        
        var q = confirm('Are you sure to make this as default?');
        if(q == true){
            $.ajax({
                type:'POST',
                url:'{{route('curriculum.default')}}',
                data:{
                    id: $id
                },
                success:function(data){
                    location.reload();
                }
            });
        }
    }

    function switchEdit($id, $name){
        console.log($id);
        console.log($name);        
        $('#btn-form').html('UPDATE');
        $('#btn-cancel').show();
        $('#update-id').remove();
        $("<input type='hidden' />")
            .attr("value", $id)
            .attr("name", "id")
            .attr("id", "update-id")
            .prependTo("#curriculum-form");        
        $('#curriculum-name').val($name);
        $('.form-line').addClass("focused");
        $('#curriculum-form').attr('action', "{{route('curriculum.edit')}}");        
        $('html, body').animate({
            scrollTop: $(".block-header").offset().top
        }, 1000);
    }

    function switchAdd(){
        $('#btn-cancel').hide();
        $('#update-id').remove();
        $('#btn-form').html('ADD');
        $('#curriculum-name').val("");
        $('.form-line').removeClass("focused");
        $('#curriculum-form').attr('action', "{{route('curriculum.add')}}");
    }
</script>
@endsection
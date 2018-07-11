@extends('layouts.app')

@section('title', 'Presence Log - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Presence Log</h2>
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
                            <div class="number count-to" data-from="0" data-to="{{Auth::user()->classes()->count()}}" data-speed="10" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                                   
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
                                            <th>Course</th>                                            
                                            <th>Room</th>
                                            <th>Schedule</th>
                                            <th>Session</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->classes()->orderBy('day', 'asc')->orderBy('start', 'asc')->get() as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data['name'] }}</td>
                                            <td>{{ $data->course['name'] }}</td>                                            
                                            <td>{{ $data->room['name'] }}</td>
                                            <td>{{ $data->the_day() }} {{ $data->class_start() }} - {{ $data->class_end() }}</td>
                                            <td>{{ $data->schedule()->count() }} Session</td>
                                            <td>
                                                <button class="btn btn-info waves-effect show-log" data-id="{{$data['id']}}" data-toggle="modal" data-target="#logModal">Log</button>                                                
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
            <div class="modal fade" id="logModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">                        
                        <div class="modal-header">
                            <h4 class="modal-title" id="logModalLabel">Modal title</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-class-infos">
                                    <thead>
                                        <tr>
                                            <th>Session</th>
                                            <th>Status</th>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".show-log").click(function(){       
        showLog($(this).data('id'));
    });

    function showLog($id){
        $.ajax({
            type:'POST',
            url:'{{route('student.presence.log')}}',
            data:{
                class_id: $id,
                user_id: {{Auth::user()->id}}
            },
            success:function(data){                
                console.log(data);
                // var d = JSON.parse(data);
                $('#logModalLabel').html(data.name);
                $("table.dashboard-class-infos tbody").empty();
                $('#class_id').val($id);
                
                if(data.log.length == 0){                    
                    $('.modal-body .table-responsive').hide();
                }
                else {
                    $('.modal-body .table-responsive').show();
                    $.each(data.log, function(key, value) {
                        var tr = $("<tr />")
                        $.each(value, function(k, v) {
                            tr.append(
                                $("<td />", {
                                html: v
                                })[0].outerHTML
                            );
                            $("table.dashboard-class-infos tbody").append(tr);
                        })
                    });
                }
            }
        });
    }    
</script>
@endsection
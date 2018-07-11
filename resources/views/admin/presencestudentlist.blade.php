@extends('layouts.app')

@section('title', 'Student List - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Student List</h2>
            </div>            
            
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>{{$class['name']}} Student List</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>                                            
                                            <th>Name</th>                                            
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($class->students as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>                                            
                                            <td>{{ $data['name'] }}</td>                                            
                                            <td>
                                                <button class="btn btn-info waves-effect show-log" data-id="{{$data['id']}}" data-toggle="modal" data-target="#logModal">LOG</button>                                                
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".show-log").click(function(){       
        showLog($(this).data('id'));
    });

    function setHadir($user_id, $session_id, $week){
        sendAct($user_id, $session_id, $week, "1");
    }

    function setIjin($user_id, $session_id, $week){
        sendAct($user_id, $session_id, $week, "2");
    }

    function setAlfa($user_id, $session_id, $week){
        sendAct($user_id, $session_id, $week, "0");
    }

    function sendAct($user_id, $session_id, $week, $act){        
        $.ajax({
            type:'POST',
            url:'{{route('presence.change')}}',
            data:{
                user_id: $user_id,
                session_id: $session_id,
                week: $week,
                action: $act
            },
            success:function(data){
                location.reload();
            }
        });        
    }

    function showLog($id){        
        $.ajax({
            type:'POST',
            url:'{{route('presence.log')}}',
            data:{
                user_id: $id,
                class_id: {{$class['id']}}                
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
@extends('layouts.app')

@section('title', 'Card Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Room Manager</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">contact_mail</i>
                        </div>
                        <div class="content">
                            <div class="text">Card</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\Card::all()->count()}}" data-speed="10" data-fresh-interval="20"></div>
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
                                ADD NEW CARD                                
                            </h2>
                        </div>                       
                        <div class="body">
                            <form method="POST" action="{{route('card.add')}}">
                                {{ csrf_field() }}
                                <div class="row clearfix">
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" id="key" name="key">
                                                <label class="form-label">Card Key</label>
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                        <button type="submit" class="btn btn-success btn-lg m-l-15 waves-effect">ADD</button>
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
                                            <th>Key</th>
                                            <th>User</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Card::all() as $data)
                                        <tr>                                        
                                            <td>{{ $loop->iteration }}</td>
                                            @if($data['status'] == "1")
                                            <td>{{ $data['key'] }}</td>
                                            @else
                                            <td><strike>{{ $data['key'] }}</strike></td>
                                            @endif
                                            <td>{{ $data->user['name'] }}</td>
                                            <td>
                                                <button type="button" class="btn btn-default waves-effect assign-card" data-id="{{$data['id']}}" data-key="{{$data['key']}}" data-toggle="modal" data-target="#assignModal">Assign User</button>
                                                @if($data['status'] == "1")
                                                <button onclick="setCard({{$data['id']}},'0')" class="btn btn-warning waves-effect">Block</button>                                                
                                                @else
                                                <button onclick="setCard({{$data['id']}},'1')" class="btn btn-success waves-effect">Unblock</button>
                                                @endif
                                                <button onclick="deleteCard({{$data['id']}})" class="btn btn-danger waves-effect">Delete</button>                                                
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
            <div class="modal fade" id="assignModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="assignModalLabel">Assign To</h4>
                        </div>
                        <form action="{{route('card.assign')}}" method="post">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="" id="assign-id">
                        <div class="modal-body">
                            <div class="col-md-12">                                
                                <select class="form-control show-tick" name="user">
                                    <optgroup label="Lecturer">
                                        @foreach(\App\User::where('role', 'lecturer')->get() as $data)
                                        <option value="{{$data['id']}}">{{$data['name']}}</option>                                     
                                        @endforeach   
                                    </optgroup>
                                    <optgroup label="Student">
                                        @foreach(\App\User::where('role', 'student')->get() as $data)
                                        <option value="{{$data['id']}}">{{$data['name']}}</option>                                     
                                        @endforeach   
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">                            
                            <button type="submit" class="btn btn-link waves-effect">ASSIGN</button>
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                        </form>
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

    $(".assign-card").click(function(){        
        showAssign($(this).data('id'), $(this).data('key'));
    });

    function showAssign($id, $key){
        $('#assign-id').val($id);
        $('#assignModalLabel').html('Assign card '+$key+' to');
    }
    
    function deleteCard($id){
        console.log($id);
        
        var q = confirm('Are you sure to delete this?');
        if(q == true){
            $.ajax({
                type:'POST',
                url:'{{route('card.delete')}}',
                data:{
                    id: $id
                },
                success:function(data){
                    location.reload();
                }
            });
        }
    }

    function setCard($id, $state){
        $.ajax({
            type:'POST',
            url:'{{route('card.set')}}',
            data:{
                id: $id,
                status: $state
            },
            success:function(data){
                location.reload();
            }
        });        
    }
</script>
@endsection
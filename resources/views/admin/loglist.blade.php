@extends('layouts.app')

@section('title', 'Log Viewer - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Log Viewer</h2>
            </div>                       
        
            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>LOG</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Room</th>
                                            <th>Card</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(App\Log::all() as $data)
                                        <tr>
                                            @if($data['room'] != null)
                                            <td>{{ $data->room['name'] }}</td>
                                            @else
                                            <td>False</td>
                                            @endif
                                            @if($data['card'] != null)
                                            <td>{{ $data->card['name'] }}</td>
                                            @else
                                            <td>False</td>
                                            @endif
                                            <td>{{ json_decode($data['status'], true)['message'] }}</td>
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
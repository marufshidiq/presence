@extends('layouts.app')

@section('title', 'Student Dashboard - ')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>            

            <!-- Widgets -->
            <div class="row clearfix">                
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-red hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">account_balance</i>
                        </div>
                        <div class="content">
                            <div class="text">CLASS</div>
                            <div class="number count-to" data-from="0" data-to="{{Auth::user()->classes()->count()}}" data-speed="1" data-fresh-interval="2"></div>
                        </div>
                    </div>
                </div>                
            </div>
            <!-- #END# Widgets -->
                       

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>WEEKLY SCHEDULE</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Day</th>
                                            <th>Room</th>
                                            <th>Course</th>
                                            <th>Lecture</th>
                                            <th>Start</th>
                                            <th>End</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->classes()->orderBy('day', 'asc')->orderBy('start', 'asc')->get() as $data)
                                        <tr>
                                            <td>{{$data->the_day()}}</td>
                                            <td>{{\App\Room::find($data->weekSchedule()['room_id'])['name']}}</td>
                                            <td>{{$data->course['name']}}</td>
                                            <td>{{$data->lecture['name']}}</td>
                                            <td>{{$data->weekSchedule()['start']}}</td>
                                            <td>{{$data->weekSchedule()['end']}}</td>
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
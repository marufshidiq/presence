@extends('layouts.app')

@section('title', 'Admin Dashboard - ')

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
                            <i class="material-icons">person_outline</i>
                        </div>
                        <div class="content">
                            <div class="text">STUDENTS</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\User::where('role', 'student')->count()}}" data-speed="1" data-fresh-interval="2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">person</i>
                        </div>
                        <div class="content">
                            <div class="text">Lecture</div>
                            <div class="number count-to" data-from="0" data-to="{{\App\User::where('role', 'lecturer')->count()}}" data-speed="1" data-fresh-interval="2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">domain</i>
                        </div>
                        <div class="content">
                            <div class="text">Room</div>                            
                            <div class="number count-to" data-from="0" data-to="{{\App\Room::count()}}" data-speed="1" data-fresh-interval="2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
                       

            <div class="row clearfix">
                <!-- Task Info -->
                <!-- <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>HISTORY</h2>                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Student Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- #END# Task Info -->
                
            </div>
        </div>
    </section>
@endsection
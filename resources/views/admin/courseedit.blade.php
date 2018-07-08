@extends('layouts.app')

@section('title', 'Course Manager - ')

@section('content')
    <section class="content">
        <div class="container-fluid">            
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EDIT NEW COURSE                                
                            </h2>                            
                        </div>
                        <div class="body">                                                        
                            <div class="row clearfix">
                                <form action="{{route('course.edit')}}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{$course['id']}}">
                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Curriculum</h4>
                                        <select class="form-control show-tick" name="curriculum">
                                            @foreach(\App\Curriculum::all() as $data)
                                            <option @if($course['curriculum_id']==$data['id']) selected @endif value="{{$data['id']}}">{{$data['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="code" id="code" value="{{$course['code']}}">
                                                <label class="form-label">Course Code</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" id="name" value="{{$course['name']}}">
                                                <label class="form-label">Course Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">SKS</h4>
                                        <div class="input-group spinner" data-trigger="spinner">
                                            <div class="form-line focused">
                                                <input type="text" class="form-control text-center" value="{{$course['sks']}}" data-rule="quantity" name="sks">
                                            </div>
                                            <span class="input-group-addon">
                                                <a href="javascript:;" class="spin-up" data-spin="up"><i class="glyphicon glyphicon-chevron-up"></i></a>
                                                <a href="javascript:;" class="spin-down" data-spin="down"><i class="glyphicon glyphicon-chevron-down"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-10">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Category</h4>
                                        <div class="demo-radio-button">                                        
                                            <input name="category" type="radio" @if($course['category']=="W") checked @endif value="W" class="with-gap" id="radio_w" />
                                            <label for="radio_w">Wajib</label>
                                            <input name="category" type="radio" @if($course['category']=="P") checked @endif value="P" class="with-gap" id="radio_p" />
                                            <label for="radio_p">Pilihan</label>                                        
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Group</h4>
                                        <select class="form-control show-tick" name="group">
                                            @foreach(['MPK','MKK','MKB','MBB'] as $data)
                                            <option @if($course['group']==$data) selected @endif value="{{$data}}">{{$data}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="submit" style="margin-bottom: 12px;" class="btn btn-success btn-lg m-l-15 waves-effect">UPDATE</button>
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
<script src="{{asset('plugins/jquery-spinner/js/jquery.spinner.js') }}"></script>
@endsection
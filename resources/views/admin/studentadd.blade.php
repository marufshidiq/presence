@extends('layouts.app')

@section('title', 'Student Manager - ')

@section('css')
<link href="{{asset('plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <section class="content">
        <div class="container-fluid">            
            <!-- Input -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                ADD NEW STUDENT                                
                            </h2>                            
                        </div>
                        <div class="body">                                                        
                            <div class="row clearfix">
                                <form action="{{route('student.add')}}" method="POST">
                                    {{ csrf_field() }}                                    
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="number" class="form-control" name="number" id="number" required>
                                                <label class="form-label">Student Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="text" class="form-control" name="name" id="name" required>
                                                <label class="form-label">Student Name</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="email" class="form-control" name="email" id="email" required>
                                                <label class="form-label">Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="password" class="form-control" name="password" id="password" required>
                                                <label class="form-label">Password</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Gender</h4>
                                        <div class="demo-radio-button">                                        
                                            <input name="gender" type="radio" value="L" class="with-gap" id="radio_w" />
                                            <label for="radio_w">Laki-laki</label>
                                            <input name="gender" type="radio" value="P" class="with-gap" id="radio_p" />
                                            <label for="radio_p">Perempuan</label>                                        
                                        </div>
                                    </div>
                                    <div class="col-sm-12" style="margin-bottom:20px;">
                                        <h4 style="font-weight:bold; font-size:13px;" class="card-inside-title">Born Date</h4>
                                        <input type="text" class="datepicker form-control inp" name="born" id="born" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" required>
                                    </div>

                                    <div class="col-sm-12">                                        
                                        <button type="submit" style="margin-bottom: 12px;" class="btn btn-success btn-lg m-l-15 waves-effect">ADD</button>
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
<script src="{{asset('plugins/momentjs/moment.js') }}"></script>
<script src="{{asset('plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<script>
    $(function () {       
        $('.datepicker').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });        
    });
</script>
@endsection
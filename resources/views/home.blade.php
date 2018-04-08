@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @if (session('status'))
              <div class="alert alert-success col-lg-12 col-md-12 col-xs-12">
                <strong>Success!</strong> {{ session('status') }}
              </div>
        @endif
        @if (session('incorrect'))
              <div class="alert alert-warning col-lg-12 col-md-12 col-xs-12">
                <strong>Success!</strong> {{ session('incorrect') }}
              </div>
        @endif
        @if ($errors->has('notSave'))
          <div class="alert alert-danger col-lg-12 col-md-12 col-xs-12">
            <strong>Error!</strong> {{ $errors->first('notSave') }}
          </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="content">
                        <div class="title" style="text-align:center;font-size:  35px;margin-bottom: 50px;">Donate!  <i class="fa fa-smile-o"></i></div>

                        <a class="btn btn-primary btn-lg btn-block" href="{{route('payment')}}" style="margin-bottom: 50px;">Pay with Paypal        <span class="glyphicon glyphicon-usd"></span></a>

                        
                          @if ($verified == 0)
                          <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-5">
                                <a class="btn btn-primary btn-lg btn-block" href="{{route('send_notification')}}"><i class="material-icons right">Send OTP to registered mobile Number<span class="glyphicon glyphicon-send"></span></a>
                              </div>
                              <div class="col-md-5">
                                {!! Form::open(['route' => 'verify_code', 'id'=>'verificationForm']) !!}
                                <input type="number" name="verify_code" value="verify_code" class="form-control">
                              </div>
                              <div class="col-md-2">
                                <button class="btn btn-success savebtn" type="submit">Verify</button>
                              {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                          @elseif ($verified == 1)
                            <div class="alert alert-success alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Success!</strong> Mobile Number verified Succesfully!
                            </div>
                          @endif






                          @if ($verified_email == 0)
                          <div class="row">
                            <div class="col-md-12">
                              <div class="col-md-5">
                                <a class="btn btn-primary btn-lg btn-block" href="{{route('send_email_notification')}}"><i class="material-icons right">Send OTP to registered Emaik Id<span class="glyphicon glyphicon-send"></span></a>
                              </div>
                              <div class="col-md-5">
                                {!! Form::open(['route' => 'verify_email_code', 'id'=>'verificationForm']) !!}
                                <input type="number" name="verify_code" value="verify_code" class="form-control">
                              </div>
                              <div class="col-md-2">
                                <button class="btn btn-success savebtn" type="submit">Verify</button>
                              {!! Form::close() !!}
                              </div>
                            </div>
                          </div>
                          @elseif ($verified_email == 1)
                            <div class="alert alert-success alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              <strong>Success!</strong> Email Id verified Succesfully!
                            </div>
                          @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
          <!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.6/js/materialize.min.js"></script>
@endsection
<script type="text/javascript">
  $('body').on('submit','#verificationForm', function(){
   $('.savebtn').prop('disabled', true);
  });
</script>

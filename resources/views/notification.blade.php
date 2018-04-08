@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Notification</div>
                <div class="panel-body">
                    <div class="content">
                        <div class="title" style="text-align:center;font-size:  35px;margin-bottom: 50px;">Add Entry In DB !  <i class="fa fa-smile-o"></i></div>


                          <div class="col-md-5">
                            {!! Form::open(['route' => 'notification.add', 'id'=>'entryAddingForm']) !!}
                            <input type="text" name="adding_text" value="" class="form-control">
                          </div>
                          <div class="col-md-2">
                            {!! Form::submit('Submit new record', ['class' => 'btn btn-primary btn-lg']) !!}
                          {!! Form::close() !!}
                          </div>

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  
  $('form#entryAddingForm').on('submit', function(event){
    event.preventDefault();
    checkAndGetData();
  });
   // $( '#entryAddingForm' ).on( 'submit', function(e) {
   //  alert(working);
   //    // e.preventDefault();
   //    // checkAndGetData();
   //  });


   function checkAndGetData() {
      alert('working');
      var data = $('input[name=adding_text]').val();
      alert(data);
      var url = "{{route('notification.add')}}";
      var token = $("input[name=_token]").val();
      console.log(url);
      // if (data != ''){
        // $.LoadingOverlay("show");
        $.ajax({
          type:'post',
          url:url,
          dataType: "json",
          data:{_token:token, entry:data},
          success:function(response){
            alert('success');
            // var table = $('#datatable-responsive').DataTable();
            // table.page('previous' ).draw( 'page' );
            // // $(".selectpicker").selectpicker();
            // // $.LoadingOverlay("hide");
          },
          error: function() {
            alert("Something went wrong! Data missing");
          }
        });
      // }
    }
</script>
@endsection




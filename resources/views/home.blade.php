@extends('layouts.default')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p>
          Ingrese datos
        </p>
      </div>
    </div>
    <div class="col-md-12">
      <form id="form-file" enctype="multipart/form-data" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group col-md-12">
          <label for="interaction">Cargue archivo de entrada</label>
          <input type="file" name="file-input" class="form-control">
        </div>
        <div class="col-md-12">
          <button type="button" class="btn btn-default">Calcular</button>
        </div>

      </form>
    </div>
  </div>

  <div class="container" style="margin-top:36px;">
    <div class="row" id="results">

    </div>
  </div>

@endsection

@push('scripts')
  <script type="text/javascript">
  $(document).ready(function(){
    $(".btn-default").on("click",function(){
      var formData = new FormData($("#form-file"));
      $.ajaxSetup(
        {
          headers:
          {
            'X-CSRF-Token': $('input[name="_token"]').val()
          }
        });
        $.ajax({
          url: "cube",
          type: "post",
          dataType: "html",
          data: new FormData($("#form-file")[0]),
          cache: false,
          contentType: false,
          processData: false
        }).done(function(data){

          obj=jQuery.parseJSON( data );

          if(obj.errors.length==0){
            $("#results").html("");
            $.each(obj.results, function(i, item) {
              $("#results").append("<div class='col-md-8 col-md-offset-2 text-center'><p>"+obj.results[i]+"</p></div>");
            })


          }else{
            $("#results").html("");
            $.each(obj.errors, function(i, item) {
              $("#results").append("<div class='col-md-8 col-md-offset-2 text-center'><p>"+obj.errors[i]+"</p></div>");
            })
          }
        });
      });
      ;
    });
    </script>
  @endpush

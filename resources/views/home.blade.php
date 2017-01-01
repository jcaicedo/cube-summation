@extends('layouts.default')
@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <p>
          Por favor cargue un archivo .txt con los datos para calcular el cubo:
        </p>

      </div>
    </div>
    <div class="col-md-12">
      <form id="form-file" enctype="multipart/form-data" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group col-md-12">
          <label for="interaction">Cargue archivo de entrada</label>
          <input type="file" name="file-input" class="form-control" required accept=".txt">
        </div>
        <div class="col-md-12">
          <button type="button" class="btn btn-default">Calcular</button>
        </div>

      </form>
    </div>
  </div>

  <div class="container" style="margin-top:36px;">
    <div class="row" id="results">
      <div class="col-md-6 col-xs-6" id="results-inputs">

      </div>
      <div class="col-md-6 col-xs-6" id="results-data">

      </div>
    </div>
  </div>

  <div class="footer" style="padding-top: 60px">
    <p>
      Desarrollador: Julio Caicedo
      Correo: caicedo.julio@gmail.com
    </p>
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
          processData: false,
          success:function(data){

            obj=jQuery.parseJSON( data );

            if(obj.errors.length==0){
              $("#results-data").html("");
              $("#results-inputs").html("");
              $("#results-inputs").append("<h3>Input</h3>");
              $("#results-data").append("<h3 style='color:green;'>Resultado</h3>");
              $.each(obj.inputs, function(i, item) {
                $("#results-inputs").append("<div class='col-md-8 col-md-offset-2'><p>"+obj.inputs[i]+"</p></div>");
              });
              $.each(obj.results, function(i, item) {
                $("#results-data").append("<div class='col-md-8 col-md-offset-2 '><p>"+obj.results[i]+"</p></div>");
              })


            }else{
              $("#results-data").html("");
              $("#results-inputs").html("");
              $("#results-inputs").append("<h3>Input</h3>");
              $("#results-data").append("<h3 style='color:red;'>Errores</h3>");
              $.each(obj.inputs, function(i, item) {
                $("#results-inputs").append("<div class='col-md-8 col-md-offset-2'><p>"+obj.inputs[i]+"</p></div>");
              });
              $.each(obj.errors, function(i, item) {
                $("#results-data").append("<div class='col-md-8 col-md-offset-2 text-center'><p style='color:red;'>"+obj.errors[i]+"</p></div>");
              })
            }
          },
          error:function(data){

          }
        });

      });
    });
    </script>
  @endpush

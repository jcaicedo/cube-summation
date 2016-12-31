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
      <form class="" action="/cube" method="post" enctype="multipart/form-data" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group col-md-12">
          <label for="interaction">Cargue archivo de entrada</label>
          <input type="file" name="file-input" class="form-control">
        </div>
        <div class="col-md-12">
          <button class="btn btn-default">Calcular</button>
        </div>

      </form>
    </div>
  </div>
@endsection

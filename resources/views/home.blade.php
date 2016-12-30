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
      <form class="" action="/cube" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
          <label for="interaction">Ingrese Número de interacciones</label>
          <input type="number" name="interaction" class="form-control">
        </div>
        <button class="btn btn-default">Calcular</button>
      </form>
    </div>
  </div>
@endsection

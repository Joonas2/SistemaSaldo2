@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Realizar Recarga.</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
           <h3>Recarga</h3>
        </div>
        <div class="card-body">
          @include('admin.includes.alerts')

            <form method="POST"  action="{{ route('deposito.store') }}">
                @csrf
                <div class="form-group">
                    <input type="text" placeholder="Valor Recarga" name="value">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success ">Recarregar</button>
                </div>

                
            </form>
        </div>
    
    
    </div>    






@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
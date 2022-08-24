@extends('adminlte::page')

@section('title', 'Nova Recarga')

@section('content_header')
    <h1>Transferir.</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
           <h3>Transferir saldo (informe o recebedor)</h3>
        </div>
        <div class="card-body">
          @include('admin.includes.alerts')

            <form method="POST"  action="{{ route('confirm.transfer') }}">
                @csrf
                <div class="form-group">
                    <input type="text" placeholder="Informe quem vai receber o saque" name="sender" style="width: 500px">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success ">Proxima etapa</button>
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
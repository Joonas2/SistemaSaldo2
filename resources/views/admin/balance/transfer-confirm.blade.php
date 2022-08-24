@extends('adminlte::page')

@section('title', 'Confirmas-transferência')

@section('content_header')
    <h1>Confirmar transferência.</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
           <h3>Confirmar Transferência Saldo</h3>
        </div>
        <div class="card-body">
          @include('admin.includes.alerts')

            <p><strong>Saldo atual: </strong>{{ number_format($balance->amount, 2, ',', '.') }}</p>
            <p><strong>Recebedor:</strong> {{ $sender->name }}</p>
           
            <form method="POST"  action="{{ route('transfer.store') }}">
                @csrf
                <input type="hidden" name="sender_id" value="{{ $sender->id }}">

                <div class="form-group">
                    <input type="text" placeholder="Valor: " name="value" style="width: 500px">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success ">Tranferir</button>
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
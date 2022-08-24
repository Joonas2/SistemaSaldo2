@extends('adminlte::page')

@section('title', 'Saldo')

@section('content_header')
    <h1>Saldo</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @include('admin.includes.alerts')
            <a href="{{ route('balance.deposito') }}" class="btn btn-primary">Recarregar</a>
            @if ($amount > 0)
                <a href="{{ route('balance.withdraw')  }}" class="btn btn-danger">Sacar</a>    
            @endif

            @if ($amount > 0)
                <a href="{{ route('balance.transfer')  }}" class="btn btn-info">Transferir</a>    
            @endif
            
        </div>
        <br>
        <div class="card-body">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>R$ {{ number_format($amount, 2, ',') }}</sup></h3>                      
                    </div>
                    <div class="icon">
                        <i class="fi-bar"></i>
                    </div>
                    <a href="#" class="small-box-footer">Historico <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>        
    </div>
@stop



@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        console.log('Hi!');
    </script>
@stop

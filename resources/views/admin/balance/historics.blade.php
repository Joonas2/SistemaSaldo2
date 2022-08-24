@extends('adminlte::page')

@section('title', 'Historico de Movimentações')

@section('content_header')
    <h1>Historico de Movimentações</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            @include('admin.includes.alerts')
           
            
        </div>
        <br>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                        <th>?Sender?</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse ($historics as $historic)
                    <tr>
                        <td>{{ $historic->id }}</th>
                        <td>{{ number_format($historic->amount, 2, ',', '.') }}</td>
                        <td>{{ $historic->type }}</td>
                        <td>{{ $historic->date }}</td>
                        <td>{{ $historic->user_id_transaction }}</td>
                    </tr>
                @empty
                        
                @endforelse
                </tbody>
            </table>
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

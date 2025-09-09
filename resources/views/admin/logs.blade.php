@extends('adminlte::page')

@section('title', 'Test Logs')

@section('content_header')
    <h1>Test Logs</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Component Test Logs</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Component</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->tanggal_uji->format('Y-m-d H:i') }}</td>
                        <td>{{ $log->komponen_terdeteksi }}</td>
                        <td>
                            @if($log->status == 'OK')
                                <span class="badge badge-success">{{ $log->status }}</span>
                            @elseif($log->status == 'FAILED')
                                <span class="badge badge-danger">{{ $log->status }}</span>
                            @else
                                <span class="badge badge-warning">{{ $log->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
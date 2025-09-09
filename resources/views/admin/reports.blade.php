@extends('adminlte::page')

@section('title', 'Reports')

@section('content_header')
    <h1>Test Reports</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Tests</p>
            </div>
            <div class="icon">
                <i class="fas fa-clipboard-list"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $stats['passed'] }}</h3>
                <p>Passed Tests</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $stats['failed'] }}</h3>
                <p>Failed Tests</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $stats['warning'] }}</h3>
                <p>Warning Tests</p>
            </div>
            <div class="icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Test Summary</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5>Success Rate</h5>
                @php
                    $successRate = $stats['total'] > 0 ? round(($stats['passed'] / $stats['total']) * 100, 1) : 0;
                @endphp
                <div class="progress mb-3">
                    <div class="progress-bar bg-success" style="width: {{ $successRate }}%">
                        {{ $successRate }}%
                    </div>
                </div>
                
                <h5>Failure Rate</h5>
                @php
                    $failureRate = $stats['total'] > 0 ? round(($stats['failed'] / $stats['total']) * 100, 1) : 0;
                @endphp
                <div class="progress mb-3">
                    <div class="progress-bar bg-danger" style="width: {{ $failureRate }}%">
                        {{ $failureRate }}%
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h5>Quick Actions</h5>
                <a href="{{ route('admin.logs') }}" class="btn btn-primary">View All Logs</a>
                <a href="{{ route('admin.components') }}" class="btn btn-info">View Components</a>
            </div>
        </div>
    </div>
</div>
@stop
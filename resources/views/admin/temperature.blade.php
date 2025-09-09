@extends('adminlte::page')

@section('title', 'Temperature Monitoring')

@section('content_header')
    <h1>Temperature Sensors</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Temperature Monitoring Dashboard</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fas fa-thermometer-half"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Current Temperature</span>
                        <span class="info-box-number" id="current-temp">25°C</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fas fa-arrow-up"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Max Today</span>
                        <span class="info-box-number">28°C</span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fas fa-arrow-down"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Min Today</span>
                        <span class="info-box-number">22°C</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> This is a simple temperature monitoring interface. 
            Connect your temperature sensors to start receiving real data.
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Sensor Status</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Sensor ID</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Last Reading</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>TEMP_01</td>
                                    <td>Room A</td>
                                    <td><span class="badge badge-success">Active</span></td>
                                    <td>25°C (2 min ago)</td>
                                </tr>
                                <tr>
                                    <td>TEMP_02</td>
                                    <td>Room B</td>
                                    <td><span class="badge badge-warning">Offline</span></td>
                                    <td>24°C (1 hour ago)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
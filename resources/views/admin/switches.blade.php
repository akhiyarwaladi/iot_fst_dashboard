@extends('adminlte::page')

@section('title', 'Smart Switches')

@section('content_header')
    <h1>Smart Switches</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Switch Control Panel</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Room Lights</h5>
                    </div>
                    <div class="card-body">
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch1" checked>
                            <label class="custom-control-label" for="switch1">Living Room</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch2">
                            <label class="custom-control-label" for="switch2">Bedroom</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch3">
                            <label class="custom-control-label" for="switch3">Kitchen</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Appliances</h5>
                    </div>
                    <div class="card-body">
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch4">
                            <label class="custom-control-label" for="switch4">Air Conditioner</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch5" checked>
                            <label class="custom-control-label" for="switch5">Water Heater</label>
                        </div>
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="switch6">
                            <label class="custom-control-label" for="switch6">Security System</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            <strong>Note:</strong> This is a simple switch control interface. 
            Connect your smart switches to enable real device control.
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Power Consumption</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Device</th>
                                    <th>Status</th>
                                    <th>Power Usage</th>
                                    <th>Daily Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Living Room Light</td>
                                    <td><span class="badge badge-success">ON</span></td>
                                    <td>15W</td>
                                    <td>$0.12</td>
                                </tr>
                                <tr>
                                    <td>Water Heater</td>
                                    <td><span class="badge badge-success">ON</span></td>
                                    <td>2500W</td>
                                    <td>$2.40</td>
                                </tr>
                                <tr>
                                    <td>Bedroom Light</td>
                                    <td><span class="badge badge-secondary">OFF</span></td>
                                    <td>0W</td>
                                    <td>$0.00</td>
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
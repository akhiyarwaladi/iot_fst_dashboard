@extends('adminlte::page')

@section('title', 'Components')

@section('content_header')
    <h1>Component Types</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detected Component Types</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($components as $component)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-microchip fa-2x text-primary mb-2"></i>
                        <h5>{{ $component->komponen_terdeteksi }}</h5>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($components->isEmpty())
        <div class="text-center">
            <p class="text-muted">No components detected yet.</p>
        </div>
        @endif
    </div>
</div>
@stop
@extends('layaout.layaout')
@section('title','Panel Principal')

@section('content')

<div class="container mt-4">
    <div class="row">
        <!-- Bienvenida -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm bg-dark text-white">
                <div class="card-body">
                    <h4 class="mb-0">👋 Bienvenido, {{ Auth::user()->name }}</h4>
                    <p class="text-muted">Has iniciado sesión correctamente en el sistema de gestión de inventario.</p>
                </div>
            </div>
        </div>

        <!-- Tarjetas resumen -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-primary">
                <div class="card-body">
                    <h5 class="card-title text-primary">📦 Productos</h5>
                    <p class="card-text">Gestiona el inventario de productos registrados.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Ir a Productos</a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-success">
                <div class="card-body">
                    <h5 class="card-title text-success">🔄 Movimientos</h5>
                    <p class="card-text">Consulta y registra entradas/salidas de inventario.</p>
                    <a href="{{ route('movements.index') }}" class="btn btn-outline-success">Ir a Movimientos</a>
                </div>
            </div>
        </div>

        <!-- Reportes -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-warning">
                <div class="card-body">
                    <h5 class="card-title text-warning">📊 Reportes</h5>
                    <p class="card-text">Genera reportes en PDF de productos y movimientos.</p>
                    <a href="{{ route('home') }}" class="btn btn-outline-warning">Ver Reportes</a>
                </div>
            </div>
        </div>

        <!-- Perfil -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-info">
                <div class="card-body">
                    <h5 class="card-title text-info">👤 Mi Perfil</h5>
                    <p class="card-text">Edita tu información personal y contraseña.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-info">Editar Perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

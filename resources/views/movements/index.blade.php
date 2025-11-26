@extends('layaout.layaout')
@section('title','Gestion de Movimientos')
@section('content')

@if (Session::has('error'))
<p style = "padding: 10px; background-color: red; color:white;">{{Session::get('error')}}</p>
@endif

    <div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Listado de movimientos</h4>
            <a href="{{route('movements.create')}}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-circle"></i> Nuevo Movimiento
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Caja de venta</th>
                        <th>Producto</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Ejemplo de fila de movimiento --}}
                    @foreach($movements as $movement)
                    <tr>
                        <td>{{ $movement->id }}</td>
                        <td>{{ $movement->type }}</td>
                        <td>{{ $movement->ammount }}</td>
                        <td>{{ $movement->sale_point }}</td>
                        <td>{{ $movement-> product->name}}</td>
                        <td class="text-center">
                            <a href="#" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Editar
                            </a>
                            <form action="#" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este movimiento?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </button>
                                     <a href="{{ route('movements.pdf', $movement->id) }}"-target="_blank" class = "btn btn-primary btn-sm"<i class = "fa-solid fa-file-pdf"> Ver PDF </i></a>

                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection
    

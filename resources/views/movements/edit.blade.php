@extends('layaout.layaout')
@section('title', 'Modificar Movimiento')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-arrow-left-right"></i> Modificar Movimiento</h4>
        </div>

        <div class="card-body">
            <form action="{{route('movements.update', $movement)}}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="type">Tipo de Movimiento</label>
                        <select name="type" id="type" class="form-control" required>
                            @foreach($movements_types as $type)
                                <option value="{{ $type }}" {{ old('type', $movement->type) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="ammount">Cantidad</label>
                        <input type="number" name="ammount" id="ammount" class="form-control" min="1" 
                               placeholder="Ej: 5" value="{{ old('ammount', $movement->ammount) }}" required>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="sale_point">Caja de Venta</label>
                        <select name="sale_point" id="sale_point" class="form-control" required>
                            <option value="" disabled>Seleccione una caja...</option>
                            <option value="caja 1" {{ old('sale_point', $movement->sale_point) == 'caja 1' ? 'selected' : '' }}>Caja 1</option>
                            <option value="caja 2" {{ old('sale_point', $movement->sale_point) == 'caja 2' ? 'selected' : '' }}>Caja 2</option>
                            <option value="caja 3" {{ old('sale_point', $movement->sale_point) == 'caja 3' ? 'selected' : '' }}>Caja 3</option>
                        </select>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <div class="col-md-12">
                        <label for="product_id" class="form-label">Seleccione un producto</label>
                        <select name="product_id" id="product_id" class="form-control" required>
                            <option value="">Seleccione un producto...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $movement->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between mt-4">
                    <!-- Botón Guardar -->
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save me-1"></i> Guardar
                    </button>

                    <!-- Botón Cancelar -->
                    <button type="reset" class="btn btn-secondary px-4">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>

                    <!-- Volver al listado -->
                    <a href="{{ route('movements.index') }}" class="btn btn-primary px-4">
                        <i class="bi bi-arrow-left-circle"></i> Volver al Listado
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layaout.layaout')
@section('title', 'Modificar Producto')
@section('content')

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Registrar Nuevo Producto</h4>
        </div>

        <div class="card-body">
            <form action="{{route('products.update', $product)}}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="codigo" class ='form-label'>Código</label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Ej: P003" value = "{{old('code', $product->code)}}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="nombre" class = 'form-label'>Nombre del Producto</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Ej: Teclado Logitech K120" value = "{{old('name', $product->name)}}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="cantidad" class ='form-label' >Cantidad</label>
                        <input type="number" name="ammount" id="ammount" class="form-control" min="1"  packeholder="Ej: 50" value = "{{old('ammount', $product->ammount)}}" required>
                        
                    </div>
                    <div class="form-group col-md-4">
                        <label for="unidad" class="form-label">Unidad</label>
                        <select name="unit" id="unit" class="form-control" aria-label="Flaoting label select">
                            <option disabled selected>Seleccione unidad de medida</option>
                            <option value="Und"{{old('unit', $product->unit) == 'Und' ?  'selected' : '' }}>Und</option>
                            <option value="Kg" {{old('unit', $product->unit) == 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="M3" {{old('unit', $product->unit) == 'M3' ? 'selected' : '' }}>M3</option>
                            <option value="L"  {{old('unit', $product->unit) == 'L' ? 'selected' : '' }}>L</option>
                            <option value="Cm" {{old('unit', $product->unit) == 'Cm' ?  'selected' : '' }}>Cm</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="precio">Precio ($)</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="1" placeholder="Ej: 120.50" required>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between mt-4">
                    <!-- Botón Guardar -->
                    <button class="btn btn-primary">Guardar <i class = "fa-solid fa-save me-1"></i></button>
                        <i class="bi bi-save
                        

                    <!-- Botón Cancelar -->
                    <button type="reset" class="btn btn-secondary px-4 ml-2">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>

                    <!-- Volver al listado -->
                    <a href="{{ route('products.index') }}" class="btn btn-primary px-4 ml-2">
                        <i class="bi bi-arrow-left-circle"></i> Volver al Listado
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

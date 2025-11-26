@extends('layaout.layaout')
@section('title','Mi Perfil')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Información de perfil -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">👤 Información de Perfil</h5>
                </div>
                <div class="card-body">
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success">Perfil actualizado correctamente.</div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group mb-3">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" class="form-control"
                                   value="{{ old('name', Auth::user()->name) }}" required autofocus>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="form-control"
                                   value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-info">Guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Actualizar contraseña -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-warning">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">🔒 Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    @if (session('status') === 'password-updated')
                        <div class="alert alert-success">Contraseña actualizada correctamente.</div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group mb-3">
                            <label for="current_password">Contraseña Actual</label>
                            <input type="password" name="current_password" id="current_password" class="form-control" required>
                            @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Nueva Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-warning">Actualizar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

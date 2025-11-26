@extends('layaout.layaout')
@section('title','Inicio de Sesión')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Gestión de Inventario - Login</h4>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success mb-3">{{ session('status') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   placeholder="Ejemplo: admin@inventario.com"
                                   value="{{ old('email') }}" required autofocus>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Ingrese su contraseña" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="remember" id="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">Recordarme</label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                            <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse</a>
                            <a href="{{ route('home') }}" class="btn btn-info">Menú sin login</a>
                        </div>
                        @if ($errors->has('email'))
                            <div class="alert alert-danger mt-3">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        @if (Route::has('password.request'))
                            <div class="mt-3 text-center">
                                <a href="{{ route('password.request') }}" class="text-muted">¿Olvidaste tu contraseña?</a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-5">
                <div class="text-center mb-4">

                    <img src="http://localhost:9000/payroll/system_resources%2Ficon-asqi.png?"
                    alt="Logo ASQI"
                    style="width: 100px; height: 100px;">
                    <h2 class="text-white fw-bold mt-2">Selamat Datang!</h2>
                    <p class="text-light">Silahkan Masuk</p>
                </div>

                <div class="card border-0 shadow-lg card-hover">
                    <div class="card-body p-5">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="text"
                                           class="form-control form-control-lg @error('login') is-invalid @enderror"
                                           id="login"
                                           name="login"
                                           placeholder="Email atau Username"
                                           value="{{ old('login') }}"
                                           required
                                           autocomplete="login"
                                           autofocus>
                                </div>
                                @error('login')
                                    <div class="invalid-feedback d-block mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Password"
                                           required
                                           autocomplete="current-password">
                                    <span class="input-group-text" id="toggle-password">
                                        <i class="bi bi-eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox"
                                           class="form-check-input"
                                           id="remember"
                                           name="remember"
                                           {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-danger text-decoration-none">
                                        Forgot Password?
                                    </a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-danger btn-lg w-100 mb-3">
                                Masuk
                            </button>

                            {{-- <div class="text-center">
                                <span class="text-muted">Don't have an account?</span>
                                <a href="{{ route('register') }}" class="text-danger text-decoration-none ms-1">
                                    Sign Up
                                </a>
                            </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.login-wrapper {
    background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
    min-height: 100vh;
    position: relative;
}

.login-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: radial-gradient(circle at center, rgba(220, 53, 69, 0.2) 0%, transparent 70%);
}

.card {
    background-color: #1e1e1e;
    border-radius: 16px;
    transition: all 0.3s ease;
    border: 1px solid rgba(220, 53, 69, 0.1);
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(220, 53, 69, 0.2);
}

.input-group-text {
    background-color: #2a2a2a;
    border: 1px solid #3a3a3a;
    border-radius: 8px 0 0 8px;
    color: #dc3545;
    cursor: pointer;
}

.form-control {
    background-color: #2a2a2a;
    border: 1px solid #3a3a3a;
    border-radius: 0 8px 8px 0;
    color: #ffffff;
}

.form-control:focus {
    background-color: #2a2a2a;
    box-shadow: none;
    border-color: #dc3545;
    color: #ffffff;
}

.form-control::placeholder {
    color: #6c757d;
}

.btn-danger {
    background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%);
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
}

.form-check-input:checked {
    background-color: #dc3545;
    border-color: #dc3545;
}

.form-check-label {
    color: #ffffff;
}

.text-muted {
    color: #6c757d !important;
}

.invalid-feedback {
    color: #dc3545;
}
</style>
@endpush

@push('scripts')
<script>
document.getElementById('toggle-password').addEventListener('click', function() {
    var passwordField = document.getElementById('password');
    var passwordIcon = this.querySelector('i');
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordIcon.classList.remove('bi-eye');
        passwordIcon.classList.add('bi-eye-slash');
    } else {
        passwordField.type = 'password';
        passwordIcon.classList.remove('bi-eye-slash');
        passwordIcon.classList.add('bi-eye');
    }
});
</script>
@endpush

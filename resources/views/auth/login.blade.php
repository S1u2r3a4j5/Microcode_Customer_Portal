@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow rounded">
                    <div class="card-header text-center bg-primary text-white fw-bold">
                        {{ __('Login') }}
                    </div>

                    <div class="card-body p-4">
                        <!-- Login Form -->
                        <form id="login-form"> <!-- Add id here -->
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <span>Don't have an account?</span>
                            <a href="{{ route('register.create') }}" class="btn btn-link">Register here</a>
                        </div>

                        <hr>

                        <!-- Or Login with Google and Facebook -->
                        <div class="text-center mb-2">
                            <a href="{{ url('login/google') }}" class="btn btn-outline-danger w-100 mb-2">
                                <i class="bi bi-google"></i> Login with Google
                            </a>
                            <a href="{{ url('login/facebook') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-facebook"></i> Login with Facebook
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> <!-- Axios -->

    <script>
        document.getElementById('login-form').addEventListener('submit', function (e) {
            e.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            axios.post('/login', {
                email: email,
                password: password
            }).then(response => {
                const token = response.data.access_token;
                localStorage.setItem('access_token', token);
                axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
                window.location.href = '/customers';  // Login ke baad customers page pe redirect karo
            }).catch(error => {
                console.error('Login failed', error);
            });
        });
    </script>

@endsection
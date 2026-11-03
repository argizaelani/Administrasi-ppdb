@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Card Login Custom -->
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                
                <div class="card-header text-center bg-white pt-5 pb-3 border-0">
                    <h2 class="fw-bold mb-0" style="color: #ff7800;">Login Panitia</h2>
                    <p class="text-muted mt-2">Selamat datang di Sistem ADM-YASFAT</p>
                </div>

                <div class="card-body px-5 pb-5">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold text-secondary">Alamat Email</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="border-radius: 10px;">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-bold text-secondary">Password</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" style="border-radius: 10px;">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label text-muted" for="remember">
                                Ingat Saya
                            </label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg py-2">
                                MASUK SISTEM
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Akhir Card -->
        </div>
    </div>
</div>
@endsection
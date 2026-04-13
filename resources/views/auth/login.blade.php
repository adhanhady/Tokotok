@extends('layouts.auth')

@section('content')

<div class="d-flex justify-content-center align-items-center" style="min-height:100vh;">

    <div class="card shadow-sm border-0 p-4" style="width:100%; max-width:400px; border-radius:20px;">

        <h4 class="fw-bold text-center mb-4">Login ke MyShop 🛒</h4>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- EMAIL -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="Masukkan email"
                       required>
            </div>

            <!-- PASSWORD -->
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Masukkan password"
                       required>
            </div>

            <!-- REMEMBER -->
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember">
                <label class="form-check-label">Ingat saya</label>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-dark w-100">
                Login
            </button>

        </form>

        <!-- REGISTER -->
        <div class="text-center mt-3">
            <small>
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-dark fw-semibold">
                    Daftar
                </a>
            </small>
        </div>

    </div>

</div>

@endsection

<style>
    .card {
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.9);
    }

    .form-control {
        border-radius: 10px;
    }

    .btn {
        border-radius: 10px;
    }
    .btn:hover {
        transform: translateY(-1px);
        transition: 0.2s;
    }
    body {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
    }
</style>
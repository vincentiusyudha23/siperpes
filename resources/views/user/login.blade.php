@extends('master')

@section('title', 'Login')

@section('content')
    <div class="w-100 vh-100 bg-primary d-flex justify-content-center align-items-center">
        <div class="card" style="width: 25%;">
            <div class="w-100 px-2 py-3 text-center">
                <h3 class="fw-bold text-primary">SIPERPES</h3>
                <span class="fw-semibold text-primary fs-5">Login</span>
            </div>
            <div class="card-body">
                <form action="{{ route('login.req') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="username" class="form-label text-secondary fw-semibold">Username</label>
                        <input class="form-control" type="text" value="{{ old('username') }}" name="username" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-secondary fw-semibold">Password</label>
                        <input class="form-control" type="password" value="{{ old('password') }}" name="password" id="password">
                    </div>
                    <div class="w-100">
                        <button type="submit" class="btn w-100 btn-primary">
                            <span class="fw-semibold">Sign In</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
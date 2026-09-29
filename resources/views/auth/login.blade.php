@extends('layouts.app')
@section('judul', 'Login')
@section('konten')
<div class="max-w-md mx-auto mt-16 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-2">Login</h1>
    <p class="text-sm text-gray-500 mb-6">Aplikasi SiLacak</p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="border rounded p-2 w-full" required autofocus>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Password</label>
            <input type="password" name="password" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4 flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember" class="text-sm">Ingat saya</label>
        </div>
        <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Masuk</button>
    </form>
    <p class="text-sm text-center mt-4">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Daftar</a></p>
    <div class="mt-6 p-3 bg-gray-50 rounded text-xs text-gray-600">
        <strong>Akun demo:</strong><br>
        Email: <code>admin@silacak.test</code><br>
        Password: <code>password</code>
    </div>
</div>
@endsection
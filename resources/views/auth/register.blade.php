@extends('layouts.app')
@section('judul', 'Registrasi')
@section('konten')
<div class="max-w-md mx-auto mt-16 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-2">Registrasi</h1>
    <p class="text-sm text-gray-500 mb-6">Buat akun baru</p>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="border rounded p-2 w-full" required autofocus>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Password</label>
            <input type="password" name="password" class="border rounded p-2 w-full" required>
        </div>
        <div class="mb-4">
            <label class="block mb-1 font-semibold text-sm">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="border rounded p-2 w-full" required>
        </div>
        <button type="submit" class="w-full bg-blue-700 text-white py-2 rounded hover:bg-blue-800">Daftar</button>
    </form>
    <p class="text-sm text-center mt-4">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a></p>
</div>
@endsection
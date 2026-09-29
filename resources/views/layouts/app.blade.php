<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiLacak - @yield('judul', 'Lacak Paket')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
<nav class="bg-blue-700 text-white p-4">
    <div class="container mx-auto flex justify-between items-center flex-wrap gap-2">
        <a href="{{ route('home') }}" class="font-bold text-xl">SiLacak</a>
        <div class="flex gap-4 text-sm flex-wrap">
            <a href="{{ route('home') }}">Lacak</a>
            <a href="{{ route('tarif.index') }}">Cek Ongkir</a>
            @auth
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('resi.index') }}">Resi</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-200 hover:underline">Logout ({{ auth()->user()->name }})</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endauth
        </div>
    </div>
</nav>
<main class="container mx-auto p-6">
    @if (session('sukses'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded border border-green-300">{{ session('sukses') }}</div>
    @endif
    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-800 rounded border border-red-300">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif
    @yield('konten')
</main>
<footer class="text-center text-xs text-gray-500 py-6">
    SiLacak — PT Sinar Logistik Nusantara (fiktif) — BNSP Senior Programmer
</footer>
</body>
</html>
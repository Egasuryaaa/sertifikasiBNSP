<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiLacak - @yield('judul', 'Lacak Paket')</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800 antialiased flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex sticky top-0 h-screen">
        <div class="p-6 border-b border-gray-100">
            <a href="{{ route('home') }}" class="font-bold text-2xl tracking-tight text-blue-600">
                SiLacak
            </a>
        </div>
        
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('home') || request()->routeIs('tracking.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Lacak Paket</a>
            <a href="{{ route('tarif.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('tarif.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Cek Ongkir</a>
            
            <div class="pt-4 mt-4 border-t border-gray-100">
                @auth
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu User</p>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Dashboard</a>
                    <a href="{{ route('resi.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('resi.*') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Manajemen Resi</a>
                @else
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Akun</p>
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('login') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2.5 rounded-md hover:bg-gray-50 hover:text-blue-600 transition-colors {{ request()->routeIs('register') ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600' }}">Register</a>
                @endauth
            </div>
        </nav>
        
        @auth
        <div class="p-4 border-t border-gray-100">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button class="w-full flex items-center justify-center px-4 py-2 text-sm text-red-600 bg-red-50 hover:bg-red-100 rounded-md transition-colors font-medium">
                    Logout ({{ auth()->user()->name }})
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen min-w-0">
        <!-- Mobile Header -->
        <div class="md:hidden bg-white border-b border-gray-200 p-4 flex justify-between items-center sticky top-0 z-50">
            <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight text-blue-600">
                SiLacak
            </a>
            <div class="text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-600 font-medium">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 font-medium">Login</a>
                @endauth
            </div>
        </div>

        <main class="flex-1 p-6 lg:p-10">
            @if (session('sukses'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-md border border-green-200">
                    {{ session('sukses') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-md border border-red-200">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                    </ul>
                </div>
            @endif
            
            @yield('konten')
        </main>

        <footer class="p-6 text-center text-sm text-gray-400 mt-auto border-t border-gray-100">
            <p>SiLacak — PT Sinar Logistik Nusantara (fiktif)</p>
            <p class="text-xs mt-1 text-gray-400">Dibuat untuk keperluan sertifikasi BNSP</p>
        </footer>
    </div>
</body>
</html>
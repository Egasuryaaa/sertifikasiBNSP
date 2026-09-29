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
    <aside class="w-64 bg-[#ee4d2d] text-white flex flex-col hidden md:flex sticky top-0 h-screen shadow-lg">
        <div class="p-6 border-b border-white/20">
            <a href="{{ route('home') }}" class="font-bold text-2xl tracking-tight text-white">
                SiLacak
            </a>
        </div>
        
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('home') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('home') || request()->routeIs('tracking.*') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Lacak Paket</a>
            <a href="{{ route('tarif.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('tarif.*') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Cek Ongkir</a>
            
            <div class="pt-4 mt-4 border-t border-white/20">
                @auth
                    <p class="px-4 text-xs font-semibold text-white/70 uppercase tracking-wider mb-2">Menu User</p>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Dashboard</a>
                    <a href="{{ route('resi.index') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('resi.*') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Manajemen Resi</a>
                @else
                    <p class="px-4 text-xs font-semibold text-white/70 uppercase tracking-wider mb-2">Akun</p>
                    <a href="{{ route('login') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('login') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2.5 rounded-md hover:bg-white/10 hover:text-white transition-colors {{ request()->routeIs('register') ? 'bg-white/20 text-white font-medium' : 'text-white/90' }}">Register</a>
                @endauth
            </div>
        </nav>
        
        @auth
        <div class="p-4 border-t border-white/20">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button class="w-full flex items-center justify-center px-4 py-2 text-sm text-[#ee4d2d] bg-white hover:bg-gray-100 rounded-md transition-colors font-medium shadow-sm">
                    Logout ({{ auth()->user()->name }})
                </button>
            </form>
        </div>
        @endauth
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-h-screen min-w-0">
        <!-- Mobile Header -->
        <div class="md:hidden bg-[#ee4d2d] p-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
            <a href="{{ route('home') }}" class="font-bold text-xl tracking-tight text-white">
                SiLacak
            </a>
            <div class="text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-white font-medium hover:text-white/80 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-white font-medium hover:text-white/80 transition-colors">Login</a>
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
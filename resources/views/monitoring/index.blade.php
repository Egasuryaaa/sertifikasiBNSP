@extends('layouts.app')
@section('judul', 'Monitoring Resource')
@section('konten')
<h1 class="text-2xl font-bold mb-6">📊 Monitoring Resource Server</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-5 rounded shadow border-l-4 border-blue-500">
        <p class="text-sm text-gray-500">PHP Version</p>
        <p class="text-2xl font-bold text-blue-700">{{ $resources['php_version'] }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-green-500">
        <p class="text-sm text-gray-500">Laravel</p>
        <p class="text-2xl font-bold text-green-600">{{ $resources['laravel_version'] }}</p>
    </div>
    <div class="bg-white p-5 rounded shadow border-l-4 border-purple-500">
        <p class="text-sm text-gray-500">OS</p>
        <p class="text-lg font-bold text-purple-700">{{ $resources['os'] }}</p>
    </div>
</div>

{{-- Memory & Disk --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold text-lg mb-4">💾 Memory</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span>Memory Limit:</span><strong>{{ $resources['memory_limit'] }}</strong></div>
            <div class="flex justify-between"><span>Memory Usage:</span><strong>{{ $resources['memory_usage'] }}</strong></div>
            <div class="flex justify-between"><span>Memory Peak:</span><strong>{{ $resources['memory_peak'] }}</strong></div>
        </div>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold text-lg mb-4">💿 Disk</h2>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between"><span>Total:</span><strong>{{ $resources['disk_total'] }}</strong></div>
            <div class="flex justify-between"><span>Used:</span><strong>{{ $resources['disk_used'] }}</strong></div>
            <div class="flex justify-between"><span>Free:</span><strong>{{ $resources['disk_free'] }}</strong></div>
            <div class="mt-3">
                <div class="w-full bg-gray-200 rounded-full h-3">
                    <div class="h-3 rounded-full {{ $resources['disk_percent'] > 80 ? 'bg-red-500' : 'bg-green-500' }}"
                         style="width: {{ $resources['disk_percent'] }}%"></div>
                </div>
                <p class="text-xs text-right mt-1">{{ $resources['disk_percent'] }}% digunakan</p>
            </div>
        </div>
    </div>
</div>

{{-- Database --}}
<div class="bg-white p-6 rounded shadow mb-6">
    <h2 class="font-bold text-lg mb-4">🗄️ Database</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
        <div><span class="text-gray-500">Connection:</span> <strong>{{ $database['connection'] }}</strong></div>
        <div><span class="text-gray-500">Database:</span> <strong>{{ $database['database'] }}</strong></div>
        <div><span class="text-gray-500">Latency:</span> <strong>{{ $database['latency'] }} ms</strong></div>
        <div><span class="text-gray-500">Status:</span>
            <span class="px-2 py-1 rounded text-xs {{ $database['status'] == 'OK' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                {{ $database['status'] }}
            </span>
        </div>
        <div><span class="text-gray-500">Total Resi:</span> <strong>{{ number_format($database['total_resi']) }}</strong></div>
        <div><span class="text-gray-500">Resi Hari Ini:</span> <strong>{{ number_format($database['resi_hari_ini']) }}</strong></div>
        <div><span class="text-gray-500">DB Size:</span> <strong>{{ $database['table_size'] }}</strong></div>
    </div>
</div>

{{-- Application --}}
<div class="bg-white p-6 rounded shadow">
    <h2 class="font-bold text-lg mb-4">⚙️ Application Config</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
        <div><span class="text-gray-500">Environment:</span>
            <span class="px-2 py-1 rounded text-xs {{ $application['app_env'] == 'production' ? 'bg-blue-100 text-blue-700' : 'bg-yellow-100 text-yellow-700' }}">
                {{ $application['app_env'] }}
            </span>
        </div>
        <div><span class="text-gray-500">Debug Mode:</span>
            <span class="px-2 py-1 rounded text-xs {{ $application['app_debug'] == 'ON' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                {{ $application['app_debug'] }}
            </span>
        </div>
        <div><span class="text-gray-500">Cache:</span> <strong>{{ $application['cache_driver'] }}</strong></div>
        <div><span class="text-gray-500">Session:</span> <strong>{{ $application['session_driver'] }}</strong></div>
        <div><span class="text-gray-500">Queue:</span> <strong>{{ $application['queue_driver'] }}</strong></div>
        <div><span class="text-gray-500">Timezone:</span> <strong>{{ $application['timezone'] }}</strong></div>
    </div>
</div>
@endsection
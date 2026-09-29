<?php

namespace App\Http\Controllers;

use App\Models\Resi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MonitoringController extends Controller
{
    public function index()
    {
        return view('monitoring.index', [
            'resources' => $this->getResourceMetrics(),
            'database' => $this->getDatabaseMetrics(),
            'application' => $this->getApplicationMetrics(),
        ]);
    }

    private function getResourceMetrics(): array
    {
        $diskTotal = disk_total_space(base_path());
        $diskFree = disk_free_space(base_path());
        $diskUsed = $diskTotal - $diskFree;

        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'os' => php_uname('s') . ' ' . php_uname('r'),
            'memory_limit' => ini_get('memory_limit'),
            'memory_usage' => round(memory_get_usage() / 1024 / 1024, 2) . ' MB',
            'memory_peak' => round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB',
            'disk_total' => round($diskTotal / 1024 / 1024 / 1024, 2) . ' GB',
            'disk_used' => round($diskUsed / 1024 / 1024 / 1024, 2) . ' GB',
            'disk_free' => round($diskFree / 1024 / 1024 / 1024, 2) . ' GB',
            'disk_percent' => round(($diskUsed / $diskTotal) * 100, 2),
        ];
    }

    private function getDatabaseMetrics(): array
    {
        $start = microtime(true);

        try {
            DB::select('SELECT 1');
            $latency = round((microtime(true) - $start) * 1000, 2);
            $status = 'OK';
        } catch (\Throwable $e) {
            $latency = null;
            $status = 'ERROR: ' . $e->getMessage();
        }

        return [
            'connection' => config('database.default'),
            'database' => config('database.connections.mysql.database'),
            'latency' => $latency,
            'status' => $status,
            'total_resi' => Resi::count(),
            'resi_hari_ini' => Resi::whereDate('created_at', today())->count(),
            'table_size' => $this->getDatabaseSize(),
        ];
    }

    private function getDatabaseSize(): string
    {
        try {
            $result = DB::select("
                SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                FROM information_schema.tables
                WHERE table_schema = ?
            ", [config('database.connections.mysql.database')]);

            return ($result[0]->size_mb ?? 0) . ' MB';
        } catch (\Throwable $e) {
            return 'N/A';
        }
    }

    private function getApplicationMetrics(): array
    {
        return [
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'queue_driver' => config('queue.default'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug') ? 'ON' : 'OFF',
            'timezone' => config('app.timezone'),
            'uptime' => $this->getUptime(),
        ];
    }

    private function getUptime(): string
    {
        if (PHP_OS_FAMILY === 'Windows') {
            return 'N/A (Windows)';
        }
        $uptime = shell_exec('uptime -p 2>/dev/null');
        return trim($uptime) ?: 'N/A';
    }
}
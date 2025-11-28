<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SampahSubmission;

class KurirDashboardController extends Controller
{
    public function index()
    {
        $kurir = Auth::user();
        // Use consistent wilayah field: prefer `village`, fallback to `adress`
        $wilayah = $kurir->village ?? $kurir->adress;

        // Get upcoming tasks (only accepted) for kurir's wilayah, ordered by nearest tanggal_pickup and waktu_pickup (ascending)
        $tasks = SampahSubmission::where('status', 'accepted')
            ->whereHas('user', function($q) use ($wilayah) {
                $q->where('village', $wilayah)->orWhere('adress', $wilayah);
            })
            ->orderBy('tanggal_pickup', 'asc')
            ->orderBy('waktu_pickup', 'asc')
            ->get();

        // Compute total incoming kilograms for this kurir (sum berat_aktual where not null, else 0)
        $totalKg = $tasks->sum(function($t) {
            return (float) ($t->berat_aktual ?? 0);
        });

        // Respect optional selected task via query param ?task={id}
        $selectedId = request()->query('task');
        $selectedTask = null;
        if ($selectedId) {
            $selectedTask = $tasks->firstWhere('id', (int)$selectedId);
        }
        if (!$selectedTask) {
            $selectedTask = $tasks->first();
        }

        return view('kurir.dashboard', compact('kurir', 'tasks', 'totalKg', 'selectedTask'));
    }

    // Show completed tasks (history) for kurir
    public function history()
    {
        $kurir = Auth::user();
        $wilayah = $kurir->village ?? $kurir->adress;

        $tasks = SampahSubmission::where('status', 'completed')
            ->whereHas('user', function($q) use ($wilayah) {
                $q->where('village', $wilayah)->orWhere('adress', $wilayah);
            })
            ->with('user')
            ->orderByDesc('tanggal_pickup')
            ->orderByDesc('waktu_pickup')
            ->get();

        // Totals for history: total weight and total points awarded for completed tasks
        $totalKg = $tasks->sum(function($t){ return (float) ($t->berat_aktual ?? 0); });
        $totalPoints = $tasks->sum(function($t){ return (int) ($t->points_awarded ?? 0); });

        return view('kurir.history', compact('kurir','tasks','totalKg','totalPoints'));
    }
}

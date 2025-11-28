<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SampahSubmission;
use App\Models\User;

class KurirSampahController extends Controller
{
    public function inputPoints(Request $request, $id)
    {
        $request->validate([
            'insentif' => 'required|in:poin,cash',
            'points' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
            'berat_aktual' => 'required|numeric|min:0',
        ]);
        $submission = SampahSubmission::findOrFail($id);
        $kurir = Auth::user();
        // Perbaikan: izinkan jika status 'accepted' dan wilayah cocok (menggunakan adress atau village yang konsisten)
        if (!($kurir && $kurir->is_kurir && $submission->user)) {
            abort(403);
        }
        // Cek kecocokan wilayah, gunakan salah satu field yang konsisten
        $wilayahKurir = $kurir->village ?? $kurir->adress;
        $wilayahUser = $submission->user->village ?? $submission->user->adress;
        if ($wilayahKurir !== $wilayahUser) {
            abort(403);
        }
        // Hanya izinkan input jika status masih accepted (belum completed)
        if ($submission->status !== 'accepted') {
            return redirect()->route('kurir.dashboard')->with('error', 'Tugas sudah selesai atau tidak valid.');
        }
        $submission->berat_aktual = $request->berat_aktual;
        if ($request->insentif === 'poin') {
            $submission->points_awarded = $request->points;
            // Tambahkan poin ke user
            if ($submission->user_id) {
                $user = User::find($submission->user_id);
                if ($user) {
                    $user->points = ($user->points ?? 0) + (int)$request->points;
                    $user->save();
                }
            }
        } else {
            $submission->points_awarded = 0;
        }
        $submission->admin_message = $request->catatan;
        $submission->status = 'completed';
        $submission->save();
        return redirect()->route('kurir.dashboard')->with('success', 'Tugas selesai.');
    }
}

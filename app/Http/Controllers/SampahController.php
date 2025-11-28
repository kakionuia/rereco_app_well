<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SampahSubmission;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SampahController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'jenisSampah' => 'required|string|max:255',
            'fotoSampah' => 'nullable|image|max:5120',
            'deskripsi' => 'required|string',
            'estimated_weight' => 'nullable|numeric|min:0',
            'metode' => 'nullable|string',

            'namaPickup' => 'nullable|string|max:255',
            'alamatPickup' => 'nullable|string',
            'tanggalPickup' => 'nullable|date',
            'jamPickup' => 'nullable|date_format:H:i',
        ]);

        // If pickup method is used, ensure pickup datetime is provided and in the future
        if (($data['metode'] ?? null) === 'pickup') {
            if (empty($data['tanggalPickup']) || empty($data['jamPickup'])) {
                return redirect()->back()->withInput()->withErrors(['tanggalPickup' => 'Tanggal dan jam penjemputan wajib diisi.']);
            }

            try {
                $pickupDateTime = Carbon::createFromFormat('Y-m-d H:i', $data['tanggalPickup'] . ' ' . $data['jamPickup']);
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->withErrors(['tanggalPickup' => 'Format tanggal atau jam tidak valid.']);
            }

            if ($pickupDateTime->lte(Carbon::now())) {
                return redirect()->back()->withInput()->withErrors(['tanggalPickup' => 'Waktu penjemputan harus di masa depan.']);
            }
        }

    $modelData = [];
    $modelData['user_id'] = auth()->id();
    $modelData['jenis'] = $data['jenisSampah'] ?? null;
    $modelData['estimated_weight'] = isset($data['estimated_weight']) ? (float) $data['estimated_weight'] : null;
    $modelData['deskripsi'] = $data['deskripsi'] ?? null;
    $modelData['metode'] = $data['metode'] ?? null;
    $modelData['status'] = 'accepted';

        if ($request->hasFile('fotoSampah')) {
            $path = $request->file('fotoSampah')->store('sampah', 'public');
            $modelData['foto_path'] = '/storage/' . $path;
        }

        // Only pickup flow is supported: save pickup details
        $modelData['nama_pickup'] = $data['namaPickup'] ?? auth()->user()?->name ?? null;
        $modelData['alamat_pickup'] = $data['alamatPickup'] ?? auth()->user()?->adress ?? null;
        $modelData['tanggal_pickup'] = $data['tanggalPickup'] ?? null;
        $modelData['waktu_pickup'] = $data['jamPickup'] ?? null;

    $submission = SampahSubmission::create($modelData);

        // optional: log activity if Activity model exists
        if (class_exists('\App\Models\Activity')) {
            \App\Models\Activity::create([
                'user_id' => auth()->id(),
                'action' => 'submit_sampah',
                'subject_type' => SampahSubmission::class,
                'subject_id' => $submission->id,
                'data' => ['jenis' => $submission->jenis],
                'ip' => $request->ip(),
            ]);
        }

        return redirect()->route('recycle')->with('success', 'Pengajuan berhasil dikirim. Terima kasih.');
    }

    // Show a submission detail to its owner
    public function show(Request $request, $id)
    {
        $submission = SampahSubmission::findOrFail($id);

        // only owner or admin can view
        if ($submission->user_id !== auth()->id() && !(auth()->check() && (auth()->user()->is_admin ?? false))) {
            abort(403);
        }

        return view('sampah.show', compact('submission'));
    }
}

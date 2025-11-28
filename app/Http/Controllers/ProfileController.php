<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Activity;
use App\Models\Order;
use App\Models\ForumThread;
use App\Models\ForumMessage;
use App\Models\SampahSubmission;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Collect recent activities from multiple sources:
        $items = [];

        // 1) Point conversion requests (Activity)
        $pointActs = Activity::where('user_id', $user->id)
            ->where('action', 'convert_points')
            ->orderByDesc('created_at')
            ->take(8)
            ->get();
        foreach ($pointActs as $a) {
            $items[] = [
                'action' => 'Permintaan konversi poin',
                'when' => $a->created_at->toDateTimeString(),
                'meta' => $a->data ?? [],
                'link' => route('profile.points'),
            ];
        }

        // 2) Orders (user purchases)
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->take(8)->get();
        foreach ($orders as $o) {
            $items[] = [
                'action' => 'Order: ' . ($o->order_number ?? $o->id),
                'when' => $o->created_at->toDateTimeString(),
                'meta' => ['status' => $o->status, 'total' => $o->total],
                'link' => route('shop.orders.show', $o->id),
            ];
        }

        // 3) Forum activity: threads and replies
        $threads = ForumThread::where('user_id', $user->id)->orderByDesc('created_at')->take(6)->get();
        foreach ($threads as $t) {
            $items[] = [
                'action' => 'Buat thread: ' . (strlen($t->title) > 60 ? substr($t->title,0,60) . '...' : $t->title),
                'when' => $t->created_at->toDateTimeString(),
                'meta' => [],
                'link' => route('forum.show', $t->id),
            ];
        }
        $replies = ForumMessage::where('user_id', $user->id)->orderByDesc('created_at')->take(6)->get();
        foreach ($replies as $r) {
            $items[] = [
                'action' => 'Balasan forum',
                'when' => $r->created_at->toDateTimeString(),
                'meta' => ['thread_id' => $r->thread_id ?? null],
                'link' => isset($r->thread_id) ? route('forum.show', $r->thread_id) : route('forum.index'),
            ];
        }

        // 4) Sampah submissions by user
        $subs = SampahSubmission::where('user_id', $user->id)->orderByDesc('created_at')->take(12)->get();
        foreach ($subs as $s) {
            $items[] = [
                'action' => 'Pengajuan sampah: ' . ($s->jenis ?? '-'),
                'when' => $s->created_at->toDateTimeString(),
                'meta' => ['status' => $s->status, 'estimated_weight' => $s->estimated_weight ?? null],
                'link' => route('sampah.show', $s->id),
            ];
        }

        // Merge and sort by time desc, limit to recent 12 entries
        usort($items, function($a,$b){ return strtotime($b['when']) - strtotime($a['when']); });
        $items = array_slice($items, 0, 12);

        return view('profile.edit', [
            'user' => $user,
            'activities' => $items,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Handle uploaded profile photo if present
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file->isValid()) {
                // delete old photo if exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }

                $path = $file->store('profile-photos', 'public');
                $user->profile_photo = $path;
            }
        }

        // Fill the rest of validated fields
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Optional: add a small activity entry (session-based)
        $activities = session()->get('activities', []);
        $activities[] = [
            'action' => 'Updated profile information',
            'when' => now()->toDateTimeString(),
        ];
        session()->put('activities', $activities);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Convert user points into e-wallet balance (simple server-side flow).
     * Rate: 1 point = 5 IDR.
     */
    public function convertPoints(Request $request): RedirectResponse
    {
        $request->validate([
            'points' => 'required|integer|min:1',
            'provider' => 'required|in:dana,gopay,ovo'
        ]);

        $user = Auth::user();
        $points = (int) $request->input('points');

        if (($user->points ?? 0) < $points) {
            return Redirect::back()->with('error', 'Poin tidak cukup untuk menukar.');
        }

        $rate = 5; // 1 point = 5 IDR
        $amount = $points * $rate;

        // Deduct points and save
        $user->points = max(0, ($user->points ?? 0) - $points);
        $user->save();

        // Log an activity for admin tracking
        try {
            Activity::create([
                'user_id' => $user->id,
                'action' => 'convert_points',
                'subject_type' => null,
                'subject_id' => null,
                'data' => [
                    'points' => $points,
                    'amount_idr' => $amount,
                    'provider' => $request->input('provider'),
                    'phone' => $user->phone ?? null,
                    'status' => 'pending'
                ],
                'ip' => $request->ip(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging errors
        }

        return Redirect::back()->with('success', "Berhasil menukar {$points} poin menjadi Rp " . number_format($amount,0,',','.') . " ke e-wallet {$request->input('provider')}. Silakan ikuti instruksi konfirmasi lebih lanjut jika diperlukan.");
    }
}

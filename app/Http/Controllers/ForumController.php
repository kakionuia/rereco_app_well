<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumThread;
use App\Models\ForumMessage;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function index()
    {
        $threads = ForumThread::withCount('messages')->orderBy('created_at','desc')->take(10)->get();
        return view('forum.index', compact('threads'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $user = Auth::user();
        $thread = ForumThread::create([
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : $data['name'] ?? null,
            'email' => $user ? $user->email : $data['email'] ?? null,
            'title' => $data['title'],
        ]);

        ForumMessage::create([
            'thread_id' => $thread->id,
            'user_id' => $user ? $user->id : null,
            'is_admin' => false,
            'body' => $data['body'],
        ]);

        return redirect()->route('forum.show', $thread->id)->with('success','Pertanyaan Anda telah dikirim. Admin akan menanggapinya.');
    }

    public function show($id)
    {
        $thread = ForumThread::with('messages')->findOrFail($id);
        return view('forum.show', compact('thread'));
    }

    public function reply(Request $request, $id)
    {
        $thread = ForumThread::findOrFail($id);

        $data = $request->validate([
            'body' => 'required|string|max:5000',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $user = Auth::user();

        ForumMessage::create([
            'thread_id' => $thread->id,
            'user_id' => $user ? $user->id : null,
            'is_admin' => $user && $user->is_admin ? true : false,
            'body' => $data['body'],
        ]);

        // Keep last updated timestamp so admin sees recent activity
        $thread->touch();

        return redirect()->route('forum.show', $thread->id)->with('success','Balasan terkirim.');
    }
}

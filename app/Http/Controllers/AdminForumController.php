<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForumThread;
use App\Models\ForumMessage;
use Illuminate\Support\Facades\Auth;

class AdminForumController extends Controller
{
    public function index()
    {
        $threads = ForumThread::orderBy('updated_at','desc')->paginate(30);
        return view('admin.forum.index', compact('threads'));
    }

    public function show($id)
    {
        $thread = ForumThread::with('messages')->findOrFail($id);
        return view('admin.forum.show', compact('thread'));
    }

    public function reply(Request $request, $id)
    {
        $thread = ForumThread::findOrFail($id);
        $data = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message = ForumMessage::create([
            'thread_id' => $thread->id,
            'user_id' => Auth::id(),
            'is_admin' => true,
            'body' => $data['body'],
        ]);

        // touch thread timestamp so it shows up in lists
        $thread->updated_at = now();
        $thread->save();

        return redirect()->route('admin.forum.show', $thread->id)->with('success','Balasan telah dikirim.');
    }
}

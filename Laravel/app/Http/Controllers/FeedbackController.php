<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'name' => $data['name'] ?? (Auth::user()->full_name ?? Auth::user()->name ?? null),
            'email' => $data['email'] ?? (Auth::user()->email ?? null),
            'message' => $data['message'],
        ]);

        return redirect()->route('feedback.form')->with('success', 'Сообщение отправлено.');
    }

    public function index()
    {
        $feedback = Feedback::with('user')->orderByDesc('created_at')->paginate(20);

        return view('admin.feedback.index', compact('feedback'));
    }
}


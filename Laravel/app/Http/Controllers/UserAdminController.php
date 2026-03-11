<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id')->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function updateRole(User $user, Request $request)
    {
        $data = $request->validate([
            'role' => ['required', 'in:admin,customer'],
        ]);

        $user->update([
            'role' => $data['role'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Роль обновлена.');
    }
}


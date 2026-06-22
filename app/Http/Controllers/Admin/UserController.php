<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->withCount('orders')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->is_admin) {
            return redirect('/admin/users')->with('error', 'User not found');
        }

        $user->load('orders', 'reviews.product');
        return view('admin.users.show', compact('user'));
    }
}

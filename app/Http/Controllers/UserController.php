<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function toggle_active(Request $request)
    {
        $user = !auth()->user()->is_admin ?: User::find($request->user_id);
        $user->deactivated_at = $user->deactivated_at ? null : Carbon::now();
        $user->save();
        return response(['message' => 'deactivated', 200]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index');
    }

    public function list(Request $request)
    {
        $sort_array = ['Ascending' => 'asc', 'Descending' => 'desc'];
        $sort_by_array = ['Date' => 'created_at', 'Type' => 'notifiable_type'];

        return auth()->user()->notifs($request)->get();
    }

    public function mark_as_read(Request $request)
    {
        auth()->user()->notifications()->find($request->notif_id)->markAsRead();
    }
}

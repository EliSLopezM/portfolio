<?php

namespace App\Http\Controllers\Admin;

use App\Models\Message;
use App\Models\Post;

class DashboardController extends AdminController
{
    public function index()
    {
        return view('admin.index', [
            'unread' => Message::unread()->count(),
            'dccPosts' => Post::forArea('dcc')->count(),
            'devPosts' => Post::forArea('develop')->count(),
            'area' => null,
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.sections.dashboard',[
            'title' => 'Dashboard',
            'menu_active' => 'dashboard',
            'nav_sub_menu' => '',
            'taskCount' => Task::count(),
        ]);
    }
}

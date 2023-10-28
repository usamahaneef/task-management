<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Partner;
use App\Models\Society;
use App\Models\University;
use App\Models\User;
use App\Models\Venue;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.sections.dashboard',[
            'title' => 'Dashboard',
            'menu_active' => 'dashboard',
            'nav_sub_menu' => '',
        ]);
    }
}

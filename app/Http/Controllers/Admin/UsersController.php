<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{

       public function index()
       {
           $users = User::all();
           return view('admin.sections.users.index', [
               'title' => 'Students',
               'menu_active' => 'users',
               'users' => $users
           ]);
       }

       public function create()
       {
           return view('admin.sections.users.create', [
               'title' => 'New user',
               'menu_active' => 'users'
           ]);
       }
   
       public function detail(User $user)
       {    
            $user->loadMissing('university');
            return view('admin.sections.users.details', [
                'title' => 'Student details',
                'menu_active' => 'users',
                'user' => $user
            ]);
       }

        public function status(Request $request , User $user)
       {
            $request->validate([
                'status' => 'nullable'
            ]);
            $user->status = $request->status;
            $user->save();
            $statusMessage = $user->status == 1 ? 'Active' : 'Inactive';
            return redirect()->route('admin.users')->with("success", "Student status " .  $statusMessage  . "");
       }
       
   
       public function delete(User $user):RedirectResponse
       {
           $user->delete();
           return redirect()->route('admin.users')->with('success', 'Student deleted successfully');
       }

    
}

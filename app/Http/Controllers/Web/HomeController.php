<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('web.index',[
            'title' => 'Home',
        ]);
    }

    public function becomePartner()
    {
        return view('web.become-partner',[
            'title' => 'become-partner',
        ]);     
    }

    public function privacyPolicy()
    {
        return view('web.privacy-policy',[
            'title' => 'privacy-policy',
        ]);  
    }

    public function accountDeletion()
    {
        return view('web.account-deletion',[
            'title' => 'privacy-policy',
        ]); 
    }
    
    
    
}

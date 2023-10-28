<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Society;
use Illuminate\Http\Request;

class SocietiesController extends Controller
{
    public function index()
    {
        $societies = Society::where('status', 1)->with('media', 'executive' , 'events')
            ->paginate(5);
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $societies
        ]);
    }

    public function detail($id)
    {
        $society = Society::with([
            'media',
            'executive',
            'events' => fn($q) => $q->whereDate('date_time', '>', date('Y-m-d'))->with('venue')->take(5)
            
        ])->find($id);
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $society
        ]);
    }
}

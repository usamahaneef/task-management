<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenuesController extends Controller
{
    public function index()
    {
        $venues = Venue::where('status', 1)->with('media' , 'events')
            ->paginate(5);
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $venues
        ]);
    }

    public function detail($id)
    {
        $venue = Venue::where('id', $id)->first();
        $venue->loadMissing('media' , 'events');
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $venue
        ]);
    }
}

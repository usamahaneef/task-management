<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 1)->with('media','venue')
            ->paginate(5);
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $events
        ]);
    }

    public function detail($id)
    {
        $event = Event::where('id', $id)->first();
        $event->loadMissing('media' , 'venue', 'society');
              
        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'data' => $event
        ]);
    }
}

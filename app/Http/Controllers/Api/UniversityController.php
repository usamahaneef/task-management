<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        $universities = University::paginate(5);

        return response()->json([
            'response' => 101,
            'message' => '',
            'validation_errors' => null,
            'universities' => $universities
        ]);
    }
}

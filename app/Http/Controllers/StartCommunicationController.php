<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StartCommunicationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return response()->json([
            'message' => 'Hello, World!',
            'payload' => $request->all(),
        ]);
    }
}

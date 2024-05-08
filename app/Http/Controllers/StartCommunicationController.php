<?php

namespace App\Http\Controllers;

use Clickbar\Magellan\Data\Geometries\Point;
use Illuminate\Http\Request;

class StartCommunicationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = Point::make(
            $request->input('latitude'),
            $request->input('longitude')
        );


        return response()->json([
            'message' => 'Hello, World!',
            'payload' => $request->all(),
        ]);
    }
}

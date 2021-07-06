<?php

namespace App\Http\Controllers;

use App\Models\Watch;
use Illuminate\Http\Request;

class WatchesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Watch::create([
            'user_id' => $request->user()->id,
            'video_id' => $request->get('video_id')
        ]);

         Log::info('video.watched', [$request->get('video_id')]);

        return response(null, 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        $now_playing = Video::findOrFail($id);
        $user = $request->user();

        $this->ensureUserCanViewVideo($user, $now_playing);

        $user->last_viewed_video_id = $id;
        $user->save();

        return view('videos.show', compact('now_playing'));
    }

    

    private function ensureUserCanViewVideo($user, $video)
    {
        if ($video->lesson->isFree() || $video->lesson->product_id <= $user->order->product_id) {
            return;
        }

        abort(403);
    }
}

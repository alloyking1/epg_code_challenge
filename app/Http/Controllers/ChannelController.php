<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChannel;
use App\Http\Resources\ChannelResource;
use Exception;
use Illuminate\Http\Request;
use App\Models\Channel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ChannelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response("got here");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreChannel $request)
    {

        try {
            //store
            $newChannel = Channel::create([
                'name' => $request->name,
                'icon' => $request->file('icon')->storePublicly('icons'),
            ]);

            //store in cache
            $cachId = 'channelId' . $newChannel->id;
            Cache::put($cachId, $newChannel, 60);

            //return resources
            return response()->json([
                'message' => "channel created",
                // 'data' => $newChannel,
                'data' => new ChannelResource($newChannel),
            ], 201);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'server error',
                'message' => 'user not created'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

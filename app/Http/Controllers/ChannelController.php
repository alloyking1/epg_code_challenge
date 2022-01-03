<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChannel;
use App\Http\Requests\updateChannel;
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
    public function index(Request $request)
    {
        $page = $request->has('page') ? $request->query('page') : 1;
        $size = $request->has('size') ? $request->query('size') : 1;

        try {
            $allChannels = Cache::remember('allChannel' . $page, 60, function () use ($size) {
                return $fetchChannels = Channel::paginate($size);
            });

            return response()->json([
                'message' => 'Success',
                'data' => $allChannels,
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'server error, channels not fetched'
            ], 500);
        }
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
    public function update(updateChannel $request, $id)
    {
        try {

            $channel = Channel::find($id);

            $updated = $channel->update([
                'name' => $request->has('name') ? $request->name : $channel->name,
                'icon' => $request->has('icon') ? $request->icon : $channel->icon
            ]);

            return response()->json([
                'message' => 'resource updated successfully',
                'data' => $channel,
                'code' => 204
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'update failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $channel = Channel::find($id);
            $channel->delete();
            if ($channel)
                return response()->json([
                    'message' => 'Deleted'
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'messae' => 'Resource not deleted'
            ], 500);
        }
    }
}

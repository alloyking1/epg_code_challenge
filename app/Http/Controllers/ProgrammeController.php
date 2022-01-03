<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProgrammeRequest;
use App\Http\Requests\UpdateProgrammeRequest;
use App\Http\Resources\ProgrammeResource;
use App\Models\Programme;
use Exception;

class ProgrammeController extends Controller
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
     * @param  \App\Http\Requests\StoreProgrammeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProgrammeRequest $request)
    {
        try {
            $storeProramme = Programme::create($request->validated());
            return response()->json([
                'message' => 'programme created',
                'data' => new ProgrammeResource($storeProramme),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Internal server error',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function show(Programme $programme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function edit(Programme $programme, $id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProgrammeRequest  $request
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProgrammeRequest $request, Programme $programme)
    {
        try {
            return $request->validated();
            $update = $programme::updated([
                'id' => $programme->id,
                'name' => $request->has('name') ? $request->name : $programme->name,
                'start_date' => $request->has('start_date') ? $request->name : $programme->start_date,
                'end_date' => $request->has('end_date') ? $request->end_date : $programme->end_date,
                'duration' => $request->has('duration') ? $request->duration : $programme->duration,
            ]);
            return response()->json([
                'message' => 'Programme update',
                'date' => new ProgrammeResource($update),
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Edit failed'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Programme  $programme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Programme $programme)
    {
        try {
            if ($programme->delete())
                return response()->json([
                    'message' => 'Programme ' . $programme->id . ' deleted'
                ], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Delete failed'
            ], 500);
        }
    }
}

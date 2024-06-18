<?php

namespace App\Http\Controllers\Api;

use App\Models\Performance;
use Illuminate\Http\Request;
use App\Http\Requests\PerformanceRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerformanceResource;

class PerformanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $performances = Performance::paginate();

        return PerformanceResource::collection($performances);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PerformanceRequest $request): Performance
    {
        return Performance::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Performance $performance): Performance
    {
        return $performance;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PerformanceRequest $request, Performance $performance): Performance
    {
        $performance->update($request->validated());

        return $performance;
    }

    public function destroy(Performance $performance): Response
    {
        $performance->delete();

        return response()->noContent();
    }
}

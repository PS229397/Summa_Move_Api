<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseResource;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $exercises = Exercise::paginate();

        return ExerciseResource::collection($exercises);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExerciseRequest $request): Exercise
    {
        return Exercise::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Exercise $exercise): Exercise
    {
        return $exercise;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExerciseRequest $request, Exercise $exercise): Exercise
    {
        $exercise->update($request->validated());

        return $exercise;
    }

    public function destroy(Exercise $exercise): Response
    {
        $exercise->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Exercise;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExerciseResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

// Add this line

class ExerciseController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Exercise index method called', ['request' => $request->all()]);

        $exercises = Exercise::paginate();

        Log::info('Exercise index method completed', ['exercises' => $exercises]);

        return ExerciseResource::collection($exercises);
    }

    public function store(ExerciseRequest $request): Exercise
    {
        Log::info('Exercise store method called', ['request' => $request->all()]);

        $exercise = Exercise::create($request->validated());

        Log::info('Exercise store method completed', ['exercise' => $exercise]);

        return $exercise;
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'exercise_photo_url' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $exercise = new Exercise($request->validated());
        $exercise->save();

        return response()->json([
            'message' => 'Exercise created successfully',
            'exercise' => $exercise
        ], 201);
    }
    public function show(Exercise $exercise): Exercise
    {
        Log::info('Exercise show method called', ['exercise' => $exercise]);

        Log::info('Exercise show method completed');

        return $exercise;
    }

    public function update(ExerciseRequest $request, Exercise $exercise): Exercise
    {
        Log::info('Exercise update method called', ['request' => $request->all(), 'exercise' => $exercise]);

        $exercise->update($request->validated());

        Log::info('Exercise update method completed', ['exercise' => $exercise]);

        return $exercise;
    }

    public function destroy(Exercise $exercise): Response
    {
        Log::info('Exercise destroy method called', ['exercise' => $exercise]);

        $exercise->delete();

        Log::info('Exercise destroy method completed');

        return response()->noContent();
    }
}

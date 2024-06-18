<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ExerciseRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $exercises = Exercise::paginate();

        return view('exercise.index', compact('exercises'))
            ->with('i', ($request->input('page', 1) - 1) * $exercises->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $exercise = new Exercise();

        return view('exercise.create', compact('exercise'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExerciseRequest $request): RedirectResponse
    {
        Exercise::create($request->validated());

        return Redirect::route('exercises.index')
            ->with('success', 'Exercise created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $exercise = Exercise::find($id);

        return view('exercise.show', compact('exercise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $exercise = Exercise::find($id);

        return view('exercise.edit', compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExerciseRequest $request, Exercise $exercise): RedirectResponse
    {
        $exercise->update($request->validated());

        return Redirect::route('exercises.index')
            ->with('success', 'Exercise updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Exercise::find($id)->delete();

        return Redirect::route('exercises.index')
            ->with('success', 'Exercise deleted successfully');
    }
}

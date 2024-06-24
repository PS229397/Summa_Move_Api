<?php

namespace App\Http\Controllers\Api;

use App\Models\Performance;
use Illuminate\Http\Request;
use App\Http\Requests\PerformanceRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\PerformanceResource;
use Illuminate\Support\Facades\Log; // Add this line

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        Log::info('Performance index method called', ['request' => $request->all()]);

        $performances = Performance::paginate();

        Log::info('Performance index method completed', ['performances' => $performances]);

        return PerformanceResource::collection($performances);
    }

    public function store(PerformanceRequest $request): Performance
    {
        Log::info('Performance store method called', ['request' => $request->all()]);

        $performance = Performance::create($request->validated());

        Log::info('Performance store method completed', ['performance' => $performance]);

        return $performance;
    }

    public function show(Performance $performance): Performance
    {
        Log::info('Performance show method called', ['performance' => $performance]);

        Log::info('Performance show method completed');

        return $performance;
    }

    public function update(PerformanceRequest $request, Performance $performance): Performance
    {
        Log::info('Performance update method called', ['request' => $request->all(), 'performance' => $performance]);

        $performance->update($request->validated());

        Log::info('Performance update method completed', ['performance' => $performance]);

        return $performance;
    }

    public function destroy(Performance $performance): Response
    {
        Log::info('Performance destroy method called', ['performance' => $performance]);

        $performance->delete();

        Log::info('Performance destroy method completed');

        return response()->noContent();
    }
}

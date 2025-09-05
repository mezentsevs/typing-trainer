<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(protected TestService $testService)
    {
    }

    public function getText(Request $request): JsonResponse
    {
        $request->validate([
            'language' => 'required|string',
            'genre' => 'nullable|string',
        ]);

        return response()->json(['text' => $this->testService->getText($request->language, auth()->id(), $request->genre)]);
    }

    public function uploadText(Request $request): JsonResponse
    {
        $request->validate([
            'language' => 'required|string',
            'file' => 'required|file|mimes:txt|max:3',
        ]);

        return response()->json([
            'message' => 'File uploaded',
            'path' => $request->file('file')->storeAs('uploads', 'test_' . auth()->id() . "_{$request->language}.txt", 'public'),
        ]);
    }

    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'language' => 'required|string',
            'time_seconds' => 'required|integer',
            'speed_wpm' => 'required|integer',
            'errors' => 'required|integer',
        ]);

        return response()->json(TestResult::create([
            'user_id' => auth()->id(),
            'language' => $request->language,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]));
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\TestGetTextRequest;
use App\Http\Requests\Test\TestSaveResultRequest;
use App\Http\Requests\Test\TestUploadTextRequest;
use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function __construct(protected TestService $testService)
    {
    }

    public function getText(TestGetTextRequest $request): JsonResponse
    {
        return response()->json([
            'text' => $this->testService->getText($request->language, auth()->id(), $request->genre),
        ]);
    }

    public function uploadText(TestUploadTextRequest $request): JsonResponse
    {
        return response()->json([
            'message' => 'File uploaded',
            'path' => $request->file('file')->storeAs(
                'uploads',
                'test_' . auth()->id() . "_{$request->language}.txt",
                'public',
            ),
        ]);
    }

    public function saveResult(TestSaveResultRequest $request): JsonResponse
    {
        return response()->json(TestResult::create([
            'user_id' => auth()->id(),
            'language' => $request->language,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]));
    }
}

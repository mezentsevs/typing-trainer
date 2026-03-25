<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Rules\GenreSupported;
use App\Rules\LanguageSupported;
use App\Rules\MaxUnsignedInteger;
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
            'language' => ['bail', 'required', new LanguageSupported()],
            'genre' => ['bail', 'nullable', new GenreSupported()],
        ]);

        return response()->json([
            'text' => $this->testService->getText($request->language, auth()->id(), $request->genre),
        ]);
    }

    public function uploadText(Request $request): JsonResponse
    {
        $request->validate([
            'language' => ['bail', 'required', 'string', new LanguageSupported()],
            'file' => 'bail|required|file|mimes:txt|max:3',
        ]);

        return response()->json([
            'message' => 'File uploaded',
            'path' => $request->file('file')->storeAs('uploads', 'test_' . auth()->id() . "_{$request->language}.txt", 'public'),
        ]);
    }

    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'language' => ['bail', 'required', 'string', new LanguageSupported()],
            'time_seconds' => ['bail', 'required', 'integer:strict', 'min:0', new MaxUnsignedInteger()],
            'speed_wpm' => ['bail', 'required', 'integer:strict', 'min:0', new MaxUnsignedInteger()],
            'errors' => ['bail', 'required', 'integer:strict', 'min:0', new MaxUnsignedInteger()],
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

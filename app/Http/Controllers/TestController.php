<?php

namespace App\Http\Controllers;

use App\Http\Requests\Test\TestGetTextRequest;
use App\Http\Requests\Test\TestUploadTextRequest;
use App\Models\TestResult;
use App\Rules\LanguageSupported;
use App\Rules\MaxUnsignedInteger;
use App\Services\TestService;
use App\Traits\Constants\WithStatisticsConstants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use WithStatisticsConstants;

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
            'path' => $request->file('file')->storeAs('uploads', 'test_' . auth()->id() . "_{$request->language}.txt", 'public'),
        ]);
    }

    public function saveResult(Request $request): JsonResponse
    {
        $request->validate([
            'language' => ['bail', 'required', 'string', new LanguageSupported()],
            'time_seconds' => ['bail', 'required', 'integer:strict', 'min:' . self::MIN_TIME_SECONDS, new MaxUnsignedInteger()],
            'speed_wpm' => ['bail', 'required', 'integer:strict', 'min:' . self::MIN_SPEED_WPM, new MaxUnsignedInteger()],
            'errors' => ['bail', 'required', 'integer:strict', 'min:' . self::MIN_ERRORS_COUNT, new MaxUnsignedInteger()],
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

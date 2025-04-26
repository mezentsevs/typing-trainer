<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function getTestText(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'genre' => 'nullable|string',
        ]);

        $text = $this->testService->getTestText(auth()->id(), $request->language, $request->genre);
        return response()->json(['text' => $text]);
    }

    public function uploadText(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'file' => 'required|file|mimes:txt',
        ]);

        $path = $request->file('file')->storeAs('uploads', "test_" . auth()->id() . "_{$request->language}.txt", 'public');
        return response()->json(['message' => 'File uploaded', 'path' => $path]);
    }

    public function saveResult(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'time_seconds' => 'required|integer',
            'speed_wpm' => 'required|integer',
            'errors' => 'required|integer',
        ]);

        $result = TestResult::create([
            'user_id' => auth()->id(),
            'language' => $request->language,
            'time_seconds' => $request->time_seconds,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($result);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use App\Services\TestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $text = $this->testService->getTestText($request->language, $request->genre);
        return response()->json(['text' => $text]);
    }

    public function uploadText(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'file' => 'required|file|mimes:txt',
        ]);

        $path = $request->file('file')->storeAs('uploads', "test_{$request->language}.txt", 'public');
        return response()->json(['message' => 'File uploaded', 'path' => $path]);
    }

    public function saveResult(Request $request)
    {
        $request->validate([
            'language' => 'required|string',
            'speed_wpm' => 'required|integer',
            'errors' => 'required|integer',
        ]);

        $result = TestResult::create([
            'user_id' => auth()->id(),
            'language' => $request->language,
            'speed_wpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($result);
    }
}

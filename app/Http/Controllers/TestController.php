<?php

namespace App\Http\Controllers;

use App\Dtos\TestRetrieveDto;
use App\Dtos\TestSaveResultDto;
use App\Dtos\TestUploadDto;
use App\Http\Requests\Test\TestRetrieveRequest;
use App\Http\Requests\Test\TestSaveResultRequest;
use App\Http\Requests\Test\TestUploadRequest;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;

class TestController extends Controller
{
    public function __construct(protected TestService $testService)
    {
    }

    public function retrieve(TestRetrieveRequest $request): JsonResponse
    {
        $dto = TestRetrieveDto::fromArray([
            'userId' => auth()->id(),
            'language' => $request->language,
            'genre' => $request->genre,
        ]);

        return response()->json(['text' => $this->testService->retrieve($dto)]);
    }

    public function upload(TestUploadRequest $request): JsonResponse
    {
        $dto = TestUploadDto::fromArray([
            'userId' => auth()->id(),
            'language' => $request->language,
            'file' => $request->file('file'),
        ]);

        return response()->json([
            'message' => 'File uploaded',
            'path' => $this->testService->upload($dto),
        ]);
    }

    public function saveResult(TestSaveResultRequest $request): JsonResponse
    {
        $dto = TestSaveResultDto::fromArray([
            'userId' => auth()->id(),
            'language' => $request->language,
            'timeSeconds' => $request->time_seconds,
            'speedWpm' => $request->speed_wpm,
            'errors' => $request->errors,
        ]);

        return response()->json($this->testService->saveResult($dto));
    }
}

<?php

namespace App\Http\Controllers;

use App\Dtos\Auth\LoginDto;
use App\Dtos\Auth\RegisterDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function me(): JsonResponse
    {
        return response()->json(['user' => $this->authService->me()]);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $dto = RegisterDto::fromArray([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json($this->authService->register($dto), 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $dto = LoginDto::fromArray([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $result = $this->authService->login($dto);

        return $result
            ? response()->json($result)
            : response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logged out']);
    }
}

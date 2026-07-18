<?php

namespace App\Http\Controllers;

use App\Dtos\LoginDto;
use App\Dtos\RegisterDto;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function me(): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        return response()->json(['user' => $user]);
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

<?php

namespace App\Http\Controllers;

use App\Dtos\RegisterDto;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'bail|required|string|email|max:255',
            'password' => 'bail|required|string|max:255',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        /**
         * @var User $user
         */
        $user = Auth::user();

        return response()->json([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => $user,
        ]);
    }

    public function logout(): JsonResponse
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        $user->tokens()->delete();
        Auth::forgetGuards();

        return response()->json(['message' => 'Logged out']);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use App\Repositories\User\UserRepository;

class AuthController
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->userRepository->findByEmail($request->email);

        if (!$user || ! Hash::check($request->password, $user->password)) {
          return response()->json([
              'message' => 'Invalid credentials',
          ], Response::HTTP_UNAUTHORIZED,);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        try {
          $request->user()->currentAccessToken()->delete();
  
          return response()->json(['message' => 'You have been successfully logged out']);
        } catch (\Throwable $th) {
          return response()->json(['message' => 'No active user session found. Unable to perform logout'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function refresh(Request $request)
    {
        try {
          $user = $request->user();
        
          // Revoga o token atual
          $request->user()->currentAccessToken()->delete();

          // Cria um novo token
          $token = $user->createToken('auth_token')->plainTextToken;

          return response()->json([
              'access_token' => $token,
              'token_type' => 'Bearer',
          ]);
        } catch (\Throwable $th) {
          return response()->json(['message' => 'Active user session not found. Token refresh failed'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function getLoggedUser(Request $request)
    {
        return response()->json($request->user());
    }
}

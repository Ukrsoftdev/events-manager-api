<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:organizations,email'],
            'password' => ['required'],
        ]);

        $user = Organization::where('email', $request->email)->first();

        if (auth()->attempt($credentials) && $user) {
            return new JsonResponse($user->createToken($request->email)->toArray());
        }

        return new JsonResponse('The provided credentials do not match our records.', 422);
    }
}

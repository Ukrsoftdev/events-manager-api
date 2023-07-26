<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        /** @var $user Organization */
        $user = Organization::where('email', $request->email)->first();

        if (Auth::attempt($credentials)) {
            return new JsonResponse($user->createToken($request->email)->toArray());
        }

        return new JsonResponse('The provided credentials do not match our records.', 422);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @param AuthLoginRequest $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function login(AuthLoginRequest $request): JsonResponse
    {
        /** @var Organization $organization */
        $organization = Organization::where('email', $request->email)->get()->first();

        if (auth()->attempt($request->validated())) {
            return response()->json($organization->createToken($request->email)->toArray());
        }

        throw ValidationException::withMessages(['The provided credentials do not match our records.']);
    }
}

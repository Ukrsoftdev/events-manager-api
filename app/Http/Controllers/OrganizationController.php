<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationResources;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;

class OrganizationController extends Controller
{
    public function list(): JsonResponse
    {
        return response()->json(OrganizationResources::collection(Organization::all()));
    }
}

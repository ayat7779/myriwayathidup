<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use Illuminate\Http\JsonResponse;

class RegionController extends Controller
{
    public function provinces(): JsonResponse
    {
        return response()->json(Province::orderBy('nama')->get());
    }

    public function regencies(Province $province): JsonResponse
    {
        return response()->json($province->regencies()->orderBy('nama')->get());
    }

    public function districts(Regency $regency): JsonResponse
    {
        return response()->json($regency->districts()->orderBy('nama')->get());
    }

    public function villages(District $district): JsonResponse
    {
        return response()->json($district->villages()->orderBy('nama')->get());
    }
}

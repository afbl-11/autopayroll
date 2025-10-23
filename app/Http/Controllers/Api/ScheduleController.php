<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\JsonResponse;

class ScheduleController extends Controller
{
    public function index(): JsonResponse
    {
        $schedules = Shift::all();

        return response()->json([
            'data' => $schedules,
            'count' => $schedules->count(),
        ]);
    }
}

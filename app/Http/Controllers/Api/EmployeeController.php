<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Employee::query();

        // Optional filters
        if ($request->has('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->has('schedule_id')) {
            $query->where('schedule_id', $request->schedule_id);
        }

        // Optional limit/pagination
        $limit = $request->get('limit', 50);
        $employees = $query->limit($limit)->get();

        return response()->json([
            'data' => $employees,
            'count' => $employees->count(),
        ]);
    }


}

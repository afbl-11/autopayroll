<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeTokenAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        \Log::info($request->bearerToken(), $request->route('id'));
        $token = $request->bearerToken();
        $employeeId = $request->route('id');

        if (!$token || !$employeeId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $employee = Employee::where('employee_id', $employeeId)
            ->where('api_token', hash('sha256', $token))
            ->first();

        if (!$employee) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->attributes->add(['employee' => $employee]);
        return $next($request);
    }

}

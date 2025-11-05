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
        $header = $request->header('Authorization');

        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $token = substr($header, 7); // remove "Bearer "

        $employee = Employee::where('api_token', hash('sha256', $token))->first();

        if (!$employee) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $request->merge(['employee' => $employee]);
        return $next($request);
    }
}

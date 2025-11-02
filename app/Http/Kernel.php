<?php

namespace App\Http;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
class Kernel  extends HttpKernel
{
    protected $routeMiddleware = [
        'employee.auth' => \App\Http\Middleware\EmployeeTokenAuth::class,
    ];
}

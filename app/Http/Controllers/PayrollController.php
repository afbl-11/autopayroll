<?php

namespace App\Http\Controllers;

use App\Services\Payroll\PayrollComputation;

class PayrollController extends Controller
{
    public function __construct(protected PayrollComputation $payroll){}
    public function index() {

    }
}

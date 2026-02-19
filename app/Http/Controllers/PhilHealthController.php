<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PhilhealthRate;
use Illuminate\Http\Request;


class PhilHealthController extends Controller
{

    public function index() {
        $rates = PhilHealthRate::latest('effectivity_year')->paginate(5);
        return view('admin.philHealth', compact('rates'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'effectivity_year' => 'required|date|unique:philhealth_rates,effectivity_year',
            'premium_rate'   => 'required|numeric|min:0|max:100',
            'salary_floor'   => 'required|numeric|min:0',
            'salary_ceiling' => 'required|numeric|gt:salary_floor', // Must be greater than floor
        ], [
            'effectivity_year.unique' => 'A contribution schedule for this date already exists.',
            'salary_ceiling.gt'     => 'The salary ceiling must be higher than the salary floor.',
        ]);

        $previousRateStatus = PhilhealthRate::where('status', 'Active')->first();

        $previousRateStatus->update(['status' => 'Historical']);

        try {


            PhilHealthRate::create($validated);


            return redirect()->back()->with('success', 'PhilHealth schedule updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
        }
    }
}

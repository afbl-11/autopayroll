<?php

namespace App\Http\Controllers;

use App\Models\PagIbigVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagIbigController extends Controller
{
    public function index(Request $request)
    {
        $versions = PagIbigVersion::orderBy('effective_date', 'desc')->get();

        // If a specific version is requested via ?version=ID, show that.
        // Otherwise, show the currently active one.
        $activeVersion = $request->has('version')
            ? PagIbigVersion::find($request->version)
            : PagIbigVersion::where('status', 'active')->first() ?? $versions->first();

        return view('admin.pagibig', compact('versions', 'activeVersion'));
    }

    public function update(Request $request, PagIbigVersion $version)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'salary_cap' => 'required|numeric|min:0',
            'employee_rate_above_threshold' => 'required|numeric|min:0',
            'employer_rate' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $version) {
            // If setting to active, deactivate all others
            if ($validated['status'] === 'active') {
                PagIbigVersion::where('id', '!=', $version->id)->update(['status' => 'inactive']);
            }

            $version->update([
                'name' => $validated['name'],
                'effective_date' => $validated['effective_date'],
                'status' => $validated['status'],
                'salary_cap' => $validated['salary_cap'],
                // Convert percentage (2.0) back to decimal (0.02)
                'employee_rate_above_threshold' => $validated['employee_rate_above_threshold'] / 100,
                'employer_rate' => $validated['employer_rate'] / 100,
            ]);
        });

        return redirect()->route('pagibig.index', ['version' => $version->id])
            ->with('success', 'Pag-IBIG policy updated successfully.');
    }

    public function clone(PagIbigVersion $version)
    {
        $newVersion = $version->replicate();
        $newVersion->name = $version->name . ' (Copy)';
        $newVersion->status = 'inactive';
        $newVersion->save();

        return redirect()->route('pagibig.index', ['version' => $newVersion->id])
            ->with('success', 'Policy cloned to a new draft.');
    }
}

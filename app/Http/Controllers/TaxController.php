<?php

namespace App\Http\Controllers;

use App\Models\TaxVersion;
use App\Models\TaxBracket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaxController extends Controller
{
    /**
     * Display the management dashboard.
     */
    public function index(Request $request)
    {
        $versions = TaxVersion::latest('effective_date')->get();

        // If a specific version is requested in URL, find it.
        // Otherwise, default to the active one.
        $activeVersion = TaxVersion::with('brackets')
            ->when($request->version, function($query) use ($request) {
                return $query->where('id', $request->version);
            })
            ->when(!$request->version, function($query) {
                return $query->active();
            })
            ->first() ?? $versions->first();

        return view('admin.tax', compact('versions', 'activeVersion'));
    }

    /**
     * Clone an existing law to a new draft.
     */
    public function clone(TaxVersion $version)
    {
        return DB::transaction(function () use ($version) {
            // Replicate the law version
            $newVersion = $version->replicate();
            $newVersion->name = "Copy of " . $version->name;
            $newVersion->status = 'inactive'; // New clones are always drafts
            $newVersion->save();

            // Replicate all brackets associated with it
            foreach ($version->brackets as $bracket) {
                $newBracket = $bracket->replicate();
                $newBracket->tax_version_id = $newVersion->id;
                $newBracket->save();
            }

            return redirect()->route('tax.index', ['version' => $newVersion->id])
                ->with('success', 'Version cloned successfully as a draft.');
        });
    }

    /**
     * Update the Version AND all its Brackets at once.
     */
    public function update(Request $request, TaxVersion $version)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'effective_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'brackets' => 'required|array',
            'brackets.*.min_income' => 'required|numeric',
            'brackets.*.percentage' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request, $version) {
            // 1. If this version is being set to 'active', deactivate ALL other versions
            if ($request->status === 'active') {
                TaxVersion::where('id', '!=', $version->id)->update(['status' => 'inactive']);
            }

            // 2. Update the main version details
            $version->update([
                'name' => $request->name,
                'effective_date' => $request->effective_date,
                'status' => $request->status,
            ]);

            // 3. Update the individual brackets
            foreach ($request->brackets as $id => $data) {
                TaxBracket::where('id', $id)
                    ->where('tax_version_id', $version->id) // Security check
                    ->update([
                        'min_income' => $data['min_income'],
                        'max_income' => $data['max_income'],
                        'base_tax'   => $data['base_tax'],
                        'excess_over' => $data['excess_over'],
                        'percentage' => $data['percentage'] / 100, // Convert e.g. 15 to 0.15
                    ]);
            }
        });

        return redirect()->route('tax.index', ['version' => $version->id])
            ->with('success', 'Tax configuration updated successfully.');
    }
}

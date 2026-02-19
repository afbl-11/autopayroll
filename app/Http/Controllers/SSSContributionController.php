<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Imports\SSSBracketImport;
use App\Models\SssVersionsTable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SSSContributionController extends Controller
{

    public function index() {
        $latestVersion = SssVersionsTable::orderBy('effective_date', 'desc')->first();

        // Get brackets for that version, or an empty collection if none exist
        $brackets = $latestVersion ? $latestVersion->brackets()->orderBy('min_salary', 'asc')->get() : collect();

        return view('admin.sss', compact('latestVersion', 'brackets'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'version_name'   => 'required|string',
            'effective_date' => 'required|date',
            'ee_rate'        => 'required|numeric',
            'er_rate'        => 'required|numeric',
            'excel_file'     => 'required|mimes:xlsx,xls,csv',
        ]);

        $version = SssVersionsTable::create([
            'version_name'   => $request->version_name,
            'effective_date' => $request->effective_date,
            'ee_rate'        => $request->ee_rate / 100,
            'er_rate'        => $request->er_rate / 100,
            'status'         => 'active',
        ]);

        try {
            Excel::import(new SSSBracketImport($version->id), $request->file('excel_file'));
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            dd($e->failures());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return back()->with('success', 'SSS Contribution Table updated successfully!');
    }
    public function downloadTemplate()
    {
        $headers = ['min_salary', 'max_salary', 'msc_amount', 'ec_er_share'];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
//            sample row
            fputcsv($file, ['0.00', '4249.99', '4000.00', '10.00']);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=sss_template.csv",
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use SimpleSoftwareIO\QrCode\Generator;

class QrCodeController extends Controller
{
    public function generate($companyId)
    {
        $company = Company::find($companyId);

        if (!$company) {
            abort(404, 'Company not found');
        }

        if (!$company->qr_token) {
            $company->qr_token = Str::uuid();
            $company->save();
        }
        //for  ease of testing purposes
        $signature = hash_hmac('sha256', $company->qr_token, env('APP_KEY'));

        $payload = [
            'company_id' => $company->company_id,
            'token' => $company->qr_token,
            'signature' => $signature,
        ];


        $qrCode = QrCode::size(250)->generate(json_encode($payload));

        return view('company.qr', compact('company', 'qrCode', 'signature'));
    }

    public function download($companyId)
    {
        $company = Company::find($companyId);

        if (!$company) {
            abort(404, 'Company not found');
        }

        if (!$company->qr_token) {
            $company->qr_token = Str::uuid();
            $company->save();
        }

        $payload = [
            'company_id' => $company->company_id,
            'token' => $company->qr_token,
            'signature' => hash_hmac('sha256', $company->qr_token, env('APP_KEY')),
        ];
        $qr = new Generator('gd');

        $qrCode = $qr->format('png')->size(250)->generate(json_encode($payload));

        $filename = Str::slug($company->company_name) . '-qr.png';

        return response($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}

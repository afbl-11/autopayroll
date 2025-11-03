<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generate($companyId)
    {
        $company = \App\Models\Company::find($companyId);

        if (!$company->qr_token) {
            $company->qr_token = Str::uuid();
            $company->save();
        }

        $payload = [
            'company_id' => $company->company_id,
            'token' => $company->qr_token,
            'signature' => hash_hmac('sha256', $company->qr_token, env('APP_KEY')),
        ];

        $qrCode = QrCode::size(250)->generate(json_encode($payload));

        return view('company.qr', compact('company', 'qrCode'));
    }
}
//todo: attendance api

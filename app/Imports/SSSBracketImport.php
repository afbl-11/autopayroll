<?php

namespace App\Imports;

use App\Models\SssBrackets;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SSSBracketImport implements ToModel, WithHeadingRow, WithValidation
{
    private $versionId;

    public function __construct($versionId)
    {
        $this->versionId = $versionId;
    }

    public function model(array $row)
    {
        return new SssBrackets([
            'version_id' => $this->versionId,
            'min_salary' => $row['min_salary'],
            'max_salary' => $row['max_salary'],
            'msc_amount' => $row['msc_amount'],
            'ec_er_share' => $row['ec_er_share'] ?? 10.00,
        ]);
    }

    public function rules(): array
    {
        return [
            'min_salary'  => 'required|numeric|min:0',
            'max_salary'  => 'nullable|numeric|',
            'msc_amount'  => 'required|numeric',
            'ec_er_share' => 'nullable|numeric',
        ];
    }
}

<?php

namespace App\Services;

use App\Models\Company;

class UpdateCompanyAddress
{
    public function updateAddress(array $data, $id) {

        $company = Company::find($id);

        $company->update($data);
    }
}

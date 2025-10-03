<?php

namespace App\Repositories;

use App\Models\Company;


class CompanyRepository
{
    public function create(array $data) {
        return Company::create($data);
    }
    public function update(array $data, $id) {
        $company = Company::find($id);
        if ($company) return $company->update($data);
        return null;
    }

    public function delete($id) {
        return Company::destroy($id);
    }
    public function getCompanies() {
        return Company::all();
    }
    public function getCompany($id) {
        return Company::find($id);
    }

    public function searchCompanies($query) {
        return Company::where('company_name', 'like' , "%$query%")->get();
    }

    public function getCompanyIndustries() {
        return Company::pluck('industry');
    }
}

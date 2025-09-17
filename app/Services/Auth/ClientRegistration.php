<?php

namespace App\Services\Auth;

use App\Models\Company;
use App\Services\GenerateId;


class ClientRegistration
{
    function __construct(
        protected GenerateId $generateId,
    )
    {}
    public function createClient(array $data) : Company {
        $data['company_id'] = $this->generateId->generateID(Company::class, 'company_id');
        return Company::create($data);
    }


}

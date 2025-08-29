<?php

namespace App\Services;

use App\Models\Company;

class ClientService
{
    function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }
    public function createClient(array $data) : Company {
        $data['company_id'] = $this->authService->generateID(Company::class, 'company_id');
        $client = Company::create($data);
        return $client;
    }

//    TODO: display clients
}

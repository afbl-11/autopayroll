<?php

namespace App\Services\Auth;

use App\Http\Requests\ClientRegistrationRequest;
use App\Models\Company;
use App\Services\GenerateId;


class ClientRegistration
{
    function __construct(
        protected GenerateId $generateId,
    )
    {}

    public function storeBasicInfo(array $data) {

        if (isset($data['first_name'])) {
            $data['first_name'] = ucwords(strtolower($data['first_name']));
        }

        if (isset($data['last_name'])) {
            $data['last_name'] = ucwords(strtolower($data['last_name']));
        }

        if (isset($data['company_name'])) {
            $data['company_name'] = ucwords(strtolower($data['company_name']));
        }


        session(['client_basic_info' => $data]);

    }

    public function storeAddress(array $data) {
        session(['client_address' => $data]);
    }
    public function getSessions() {
        $basicInfo = session('client_basic_info');
        $address = session('client_address');
        $ownerName = $basicInfo['first_name'] . ' ' . $basicInfo['last_name'];

        return [
            'data' => array_merge($basicInfo, $address),
            'owner' => $ownerName
        ];
    }
    public function createClient() : Company {
        $basicInfo = session('client_basic_info');
        $address = session('client_address');

        $data = array_merge($basicInfo, $address);

        $data['company_id'] = $this->generateId->generateID(Company::class, 'company_id');
        return Company::create($data);
    }


}

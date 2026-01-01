<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRegistrationRequest;
use App\Http\Requests\CompanyAddressRequest;
use App\Services\Auth\ClientRegistration;

class ClientRegistrationController extends Controller
{
    function __construct(
        protected ClientRegistration $clientService,
//     protected CompanyAddressRequest $companyAddressRequest,
    )

    {}
    public function storeBasicInformation(ClientRegistrationRequest $request) {
        $data = $request->validated();

        if ($request->hasFile('company_logo')) {
            $data['company_logo'] = $request->file('company_logo')
                ->store('company_logos', 'public');
        } else {
            $data['company_logo'] = null;
        }

        $this->clientService->storeBasicInfo($data);

        return redirect()->route('show.register.client.map');
    }
    public function showCompanyMap() {

        return view('auth.company-address')->with(['title' => 'Client Registration']);
    }

    public function showReview() {
       $sessions = $this->clientService->getSessions();
        return view('auth.company-register-review', ['data' => $sessions['data'], 'ownerName' => $sessions['owner']])->with(['title' => 'Review Details']);
    }

    public function storeAddress(CompanyAddressRequest $request) {
        $this->clientService->storeAddress($request->validated());

        return redirect()->route('show.client.register.review');
    }

    public function register() {
        $this->clientService->createClient();

        return redirect()->route('dashboard')->with('success', 'Successfully Registered Company.');
    }
    public function showForm() {
        return view('auth.company-register')->with(['title' => 'Client Registration']);
    }


}

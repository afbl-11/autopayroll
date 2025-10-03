<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRegistrationRequest;
use App\Services\Auth\ClientRegistration;

class ClientRegistrationController extends Controller
{
    function __construct(
        protected ClientRegistration $clientService)
    {}
    public function register(ClientRegistrationRequest $request) {
        $this->clientService->createClient($request->validated());

        return redirect()->route('register.client');
    }
    public function showForm() {
        return view('admin.admin');
    }


}

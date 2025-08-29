<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRegistration;
use App\Services\ClientService;

class ClientController extends Controller
{
    function __construct(ClientService $clientService) {
        $this->clientService = $clientService;
    }
    public function register(ClientRegistration $request) {
        $this->clientService->createClient($request->validated());

        return redirect()->route('register.client');
    }
    public function showForm() {
        return view('admin.admin');
    }


}

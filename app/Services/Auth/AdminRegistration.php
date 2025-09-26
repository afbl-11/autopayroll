<?php

namespace App\Services\Auth;
use App\Models\Admin;
use App\Services\GenerateId;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class AdminRegistration
{

    public function __construct(
        protected GenerateId $generateId
    )
    {}

    public function processStep1(array $data): void
    {
        session(['register.personal' => $data]);
    }

    public function createAdmin(array $data): Admin
    {
        $personal = session('register.personal');
        $data = array_merge($personal, $data);
        $data['password'] = Hash::make($data['password']);
        $data['admin_id'] = $this->generateId->generateId(Admin::class, 'admin_id');

        $admin = Admin::create($data);

        event(new Registered($admin));

        session()->forget('register.personal');

        return $admin;
    }

}

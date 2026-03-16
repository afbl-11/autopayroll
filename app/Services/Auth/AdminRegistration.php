<?php

namespace App\Services\Auth;
use App\Models\Admin;
use App\Services\GenerateId;
use App\Services\Payroll\PayrollPeriodService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminRegistration
{

    public function __construct(
        protected GenerateId $generateId,
        protected PayrollPeriodService $periodService,
    )
    {}

    public function processStep1(array $data): void
    {
        if (isset($data['first_name'])) {
            $data['first_name'] = ucwords(strtolower($data['first_name']));
        }

        if (isset($data['last_name'])) {
            $data['last_name'] = ucwords(strtolower($data['last_name']));
        }

        if (isset($data['middle_name'])) {
            $data['middle_name'] = ucwords(strtolower($data['middle_name']));
        }

        session(['register.personal' => $data]);
    }

    public function createAdmin(array $data): Admin
    {
        $personal = session('register.personal');

        // Safety check: if session expired, redirect back
        if (!$personal) {
            throw new \Exception("Registration session expired.");
        }

        $combinedData = array_merge($personal, $data);
        $combinedData['password'] = Hash::make($combinedData['password']);
        $combinedData['profile_photo'] = 'profile-photos/default_profile.jpg';
        $combinedData['admin_id'] = $this->generateId->generateId(Admin::class, 'admin_id');

        // Wrap in a transaction
        return DB::transaction(function () use ($combinedData) {
            $admin = Admin::create($combinedData);

            // If this fails, the whole block throws an exception and rolls back
            $this->periodService->createPeriod($combinedData['admin_id']);

            // Fire event ONLY if DB operations succeeded
            event(new Registered($admin));

            session()->forget('register.personal');

            return $admin;
        });
    }

}

<?php

namespace App\Services\Auth;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function generateAdminId(): string
    {
        $year = Carbon::now()->year;

        $lastAdmin = Admin::where('admin_id', 'like', "$year-%")
            ->orderBy('admin_id', 'desc')
            ->first();

        if ($lastAdmin) {
            $lastNumber = (int)substr($lastAdmin->admin_id, 5);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function createAdmin(array $data): Admin
    {
        $data['admin_id'] = $this->generateAdminId();
        $data['password'] = Hash::make($data['password']);

        return Admin::create($data);
    }
}

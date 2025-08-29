<?php

namespace App\Services;
use App\Models\Admin;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function generateId(string $modelClass, string $idColumn): string
    {
        $year = Carbon::now()->year;

        $lastRecord = $modelClass::where($idColumn, 'like', "$year%")
            ->orderBy($idColumn, 'desc')
            ->first();

        $newNumber = $lastRecord ? (int)substr($lastRecord->$idColumn, 5) + 1 : 1;

        return $year . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function processStep1(array $data): void
    {
        session(['register.personal' => $data]);
    }

    public function createAdmin(array $data): Admin
    {
        $personal = session('register.personal');
        $data = array_merge($personal, $data);
        $data['password'] = Hash::make($data['password']);
        $data['admin_id'] = $this->generateId(Admin::class, 'admin_id');

        $admin = Admin::create($data);
        session()->forget('register.personal');

        return $admin;
    }

}

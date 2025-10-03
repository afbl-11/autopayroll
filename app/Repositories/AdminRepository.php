<?php

namespace App\Repositories;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AdminRepository
{
    public function create(array $data)
    {
        return Admin::create($data);
    }
    public function signedAdmin() {
        return Auth::guard('admin')->user();
    }

    public function update(array $data, $id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->update($data);
            return $admin;
        }
        return null;
    }

    public function delete($id)
    {
        return Admin::destroy($id);
    }

    public function getById($id)
    {
        return Admin::find($id);
    }

    public function getAll()
    {
        return Admin::all();
    }

    public function getByEmail($email)
    {
        return Admin::where('email', $email)->first();
    }

    public function getByRole($role)
    {
        return Admin::where('role', $role)->get();
    }

    public function getUnverifiedAdmins()
    {
        return Admin::whereNull('email_verified_at')->get();
    }

    public function getVerifiedAdmins()
    {
        return Admin::whereNotNull('email_verified_at')->get();
    }

    public function searchAdmins($query)
    {
        return Admin::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->get();
    }
}

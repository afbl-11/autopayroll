<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Services\GenerateId;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        $regions = [
            'NCR', 'CAR', 'Region I', 'Region II', 'Region III', 'Region IV-A', 'Region IV-B',
            'Region V', 'Region VI', 'Region VII', 'Region VIII', 'Region IX', 'Region X',
            'Region XI', 'Region XII', 'Region XIII', 'BARMM'
        ];

        $provinces = [
            'Metro Manila', 'Ilocos Norte', 'Cebu', 'Davao del Sur', 'Bohol', 'Pampanga', 'Laguna', 'Cavite'
        ];

        return [
            'admin_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'role' => $this->faker->randomElement(['superadmin', 'admin', 'manager']),
            'password' => Hash::make('Str0ng_P@ass'), // default password
            'tin' => $this->faker->numerify('###-###-###-###'),
            'company_name' => $this->faker->company,
            'country' => 'Philippines',
            'region' => $this->faker->randomElement($regions),
            'province' => $this->faker->randomElement($provinces),
            'city' => $this->faker->city,
            'zip' => $this->faker->postcode,
            'barangay' => 'Brgy. ' . $this->faker->streetName,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'email_verified_at' => now(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

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
        $admin = Admin::inRandomOrder()->first();

        return [
            'company_id' =>  Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'admin_id' => $admin->admin_id,
            'company_name' => $this->faker->company,
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'company_logo' => null,
            'industry'     => $this->faker->randomElement(['IT', 'Manufacturing', 'Retail', 'Finance', 'Services']),
            'tin_number'   => $this->faker->numerify('###-###-###-###'),
            'address'      => $this->faker->address,
            'latitude'     => $this->faker->latitude(5, 20),
            'longitude'    => $this->faker->longitude(115, 126),
            'radius'       => $this->faker->numberBetween(100, 1000),
        ];
    }
}

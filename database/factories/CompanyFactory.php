<?php

namespace Database\Factories;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
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

        return [
            'company_id' =>  Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'company_name' => $this->faker->company,
            'country' => 'Philippines',
            'region' => $this->faker->randomElement($regions),
            'province' => $this->faker->randomElement($provinces),
            'city' => $this->faker->city,
            'barangay' => 'Brgy. ' . $this->faker->streetName,
            'street' => $this->faker->streetName,
            'house_number' => $this->faker->buildingNumber,
            'zip' => $this->faker->postcode,
            'industry' => $this->faker->randomElement(['IT', 'Manufacturing', 'Retail', 'Finance', 'Services']),
            'tin_number' => $this->faker->numerify('###-###-###-###'),
            'latitude'     => $this->faker->latitude(5, 20),
            'longitude'    => $this->faker->longitude(115, 126),
        ];
    }
}

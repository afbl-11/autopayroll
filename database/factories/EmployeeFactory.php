<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = \App\Models\Employee::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_PH');
        $company = Company::inRandomOrder()->first();
        $schedule = Schedule::inRandomOrder()->first();

        $barangays = ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4'];
        $jobs = ['Janitor', 'Driver', 'Window Washer', 'Electrician'];

        // Generate fake address set
        $resAddress = [
            'country' => 'Philippines',
            'country_code' => 'PH',
            'region' => $faker->state,
            'region_code' => strtoupper(substr($faker->stateAbbr, 0, 3)),
            'province' => $faker->state,
            'province_code' => strtoupper(substr($faker->stateAbbr, 0, 3)),
            'zip' => $faker->postcode,
            'zip_code' => $faker->postcode,
            'city' => $faker->city,
            'city_code' => strtoupper(substr($faker->citySuffix, 0, 3)),
            'barangay' => $faker->randomElement($barangays),
            'barangay_code' => 'BRG' . rand(100, 999),
            'street' => $faker->streetName,
            'street_code' => 'STR' . rand(100, 999),
            'house_number' => $faker->buildingNumber,
            'house_number_code' => 'H' . rand(100, 999),
        ];

        // Optionally make ID address same or different
        $sameAddress = $faker->boolean(50); // 50% chance to be same

        $idAddress = $sameAddress ? $resAddress : [
            'country' => 'Philippines',
            'country_code' => 'PH',
            'region' => $faker->state,
            'region_code' => strtoupper(substr($faker->stateAbbr, 0, 3)),
            'province' => $faker->state,
            'province_code' => strtoupper(substr($faker->stateAbbr, 0, 3)),
            'zip' => $faker->postcode,
            'zip_code' => $faker->postcode,
            'city' => $faker->city,
            'city_code' => strtoupper(substr($faker->citySuffix, 0, 3)),
            'barangay' => $faker->randomElement($barangays),
            'barangay_code' => 'BRG' . rand(100, 999),
            'street' => $faker->streetName,
            'street_code' => 'STR' . rand(100, 999),
            'house_number' => $faker->buildingNumber,
            'house_number_code' => 'H' . rand(100, 999),
        ];

        return [
            'employee_id' => Carbon::now()->year . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
            'company_id' => $company?->company_id,
            'schedule_id' => $schedule?->schedule_id,
            'first_name' => $faker->firstName,
            'middle_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'username' => $faker->unique()->userName,
            'password' => bcrypt('Str0ngPass!'),
            'job_position' => $faker->randomElement($jobs),
            'contract_start' => $faker->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'contract_end' => $faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'employment_type' => $faker->randomElement(['fulltime', 'part-time', 'contractual']),
            'birthdate' => $faker->date('Y-m-d', '2000-12-31'),
            'gender' => $faker->randomElement(['male', 'female']),
            'marital_status' => $faker->randomElement(['single', 'married', 'widowed']),
            'blood_type' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'religion' => $faker->word,
            'phone_number' => $faker->numerify('09#########'),

            // Residential Address
            'res_country' => $resAddress['country'],
            'res_country_code' => $resAddress['country_code'],
            'res_region' => $resAddress['region'],
            'res_region_code' => $resAddress['region_code'],
            'res_province' => $resAddress['province'],
            'res_province_code' => $resAddress['province_code'],
            'res_zip' => $resAddress['zip'],
            'res_zip_code' => $resAddress['zip_code'],
            'res_city' => $resAddress['city'],
            'res_city_code' => $resAddress['city_code'],
            'res_barangay' => $resAddress['barangay'],
            'res_barangay_code' => $resAddress['barangay_code'],
            'res_street' => $resAddress['street'],
            'res_street_code' => $resAddress['street_code'],
            'res_house_number' => $resAddress['house_number'],
            'res_house_number_code' => $resAddress['house_number_code'],

            // ID Address
            'id_country' => $idAddress['country'],
            'id_country_code' => $idAddress['country_code'],
            'id_region' => $idAddress['region'],
            'id_region_code' => $idAddress['region_code'],
            'id_province' => $idAddress['province'],
            'id_province_code' => $idAddress['province_code'],
            'id_zip' => $idAddress['zip'],
            'id_zip_code' => $idAddress['zip_code'],
            'id_city' => $idAddress['city'],
            'id_city_code' => $idAddress['city_code'],
            'id_barangay' => $idAddress['barangay'],
            'id_barangay_code' => $idAddress['barangay_code'],
            'id_street' => $idAddress['street'],
            'id_street_code' => $idAddress['street_code'],
            'id_house_number' => $idAddress['house_number'],
            'id_house_number_code' => $idAddress['house_number_code'],

            // Account & Gov Info
            'bank_account_number' => $faker->bankAccountNumber,
            'sss_number' => $faker->numerify('##########'),
            'phil_health_number' => $faker->numerify('############'),
            'pag_ibig_number' => $faker->numerify('############'),
            'tin_number' => $faker->numerify('#########'),
        ];
    }
}

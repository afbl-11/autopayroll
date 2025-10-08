<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Schedule;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $faker = \Faker\Factory::create('en_PH');

        $company = Company::inRandomOrder()->first();
        $schedule = Schedule::inRandomOrder()->first();

        $barangays = ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4'];
        $jobs = ['Janitor', 'Driver', 'Window Washer', 'Electrician'];

        // Generate residential address
        $resAddress = [
            'country' => 'Philippines',
            'region' => $faker->state,
            'province' => $faker->state,
            'zip' => $faker->postcode,
            'city' => $faker->city,
            'barangay' => $faker->randomElement($barangays),
            'street' => $faker->streetName,
            'house_number' => $faker->buildingNumber,
        ];

        // ID address: 50% chance to be same as residential
        $sameAddress = $faker->boolean(50);
        $idAddress = $sameAddress ? $resAddress : [
            'country' => 'Philippines',
            'region' => $faker->state,
            'province' => $faker->state,
            'zip' => $faker->postcode,
            'city' => $faker->city,
            'barangay' => $faker->randomElement($barangays),
            'street' => $faker->streetName,
            'house_number' => $faker->buildingNumber,
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
            'employment_type' => $faker->randomElement(['fulltime', 'part-time', 'contractual']),
            'contract_start' => $faker->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'contract_end' => $faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'birthdate' => $faker->date('Y-m-d', '2000-12-31'),
            'gender' => $faker->randomElement(['male', 'female']),
            'marital_status' => $faker->randomElement(['single', 'married', 'widowed']),
            'blood_type' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
            'religion' => $faker->word,
            'phone_number' => $faker->numerify('09#########'),

            // Residential Address
            'country' => $resAddress['country'],
            'region' => $resAddress['region'],
            'province' => $resAddress['province'],
            'zip' => $resAddress['zip'],
            'city' => $resAddress['city'],
            'barangay' => $resAddress['barangay'],
            'street' => $resAddress['street'],
            'house_number' => $resAddress['house_number'],

            // ID Address
            'id_country' => $idAddress['country'],
            'id_region' => $idAddress['region'],
            'id_province' => $idAddress['province'],
            'id_zip' => $idAddress['zip'],
            'id_city' => $idAddress['city'],
            'id_barangay' => $idAddress['barangay'],
            'id_street' => $idAddress['street'],
            'id_house_number' => $idAddress['house_number'],

            // Accounts and government IDs
            'bank_account_number' => $faker->bankAccountNumber,
            'sss_number' => $faker->numerify('##########'),
            'phil_health_number' => $faker->numerify('############'),
            'pag_ibig_number' => $faker->numerify('############'),
            'tin_number' => $faker->numerify('#########'),
        ];
    }
}

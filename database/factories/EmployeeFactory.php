<?php

namespace Database\Factories;

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


        $barangays = ['Barangay 1', 'Barangay 2', 'Barangay 3', 'Barangay 4'];
        $jobs = ['Janitor','Driver','Window Washer','Driver'];

        return [
            'employee_id' => '2024' . $faker->numerify('####'),
            'company_id' => 'COMP001',
            'schedule_id' => 1,
            'first_name' => $faker->firstName,
            'middle_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'username' => $faker->unique()->userName,
            'password' => bcrypt('Str0ngPass!'),
            'job_position' => $faker->randomElement($jobs),
            'contract_start' => $faker->dateTimeBetween('-2 years', '-1 year')->format('Y-m-d'),
            'contract_end' => $faker->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'employment_type' => $faker->randomElement(['fulltime','part-time','contractual']),
            'birthdate' => $faker->date('Y-m-d', '2000-12-31'),
            'gender' => $faker->randomElement(['male','female']),
            'marital_status' => $faker->randomElement(['single','married','widowed']),
            'blood_type' => $faker->randomElement(['A+','A-','B+','B-','AB+','AB-','O+','O-']),
            'religion' => $faker->word,
            'country' => 'Philippines',
            'region' => $faker->state,
            'province' => $faker->state,
            'zip' => $faker->postcode,
            'city' => $faker->city,
            'barangay' => $faker->randomElement($barangays),
            'street' => $faker->streetName,
            'house_number' => $faker->buildingNumber,
            'phone_number' => $faker->numerify('09#########'),
            'bank_account_number' => $faker->bankAccountNumber,
            'sss_number' => $faker->numerify('##-#######-#'),
            'phil_health_number' => $faker->numerify('############'),
            'pag_ibig_number' => $faker->numerify('############'),
            'tin_number' => $faker->numerify('###-###-###'),
        ];
    }
}

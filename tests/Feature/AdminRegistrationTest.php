<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\TestCase;


class AdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_complete_two_step_registration()
    {
        // Step 1: Personal Info
        $response1 = $this->post('/admin_dashboard/', [
            'first_name' => 'Marc',
            'last_name' => 'Afable',
            'email' => 'marc@example.com',
            'tin' => '123456789',
            'role' => 'admin_dashboard',
            'password' => 'Password@123',
        ]);

        // Should redirect to Step 2
        $response1->assertRedirect('/admin_dashboard/address');
        $this->assertSessionHas('register.personal');

        // Step 2: Address Info
        $response2 = $this->post('/admin_dashboard/register', [
            'country' => 'Philippines',
            'region' => 'NCR',
            'province' => 'Metro Manila',
            'city' => 'Makati',
            'barangay' => 'Bel-Air',
            'street' => 'Ayala Avenue',
            'house_number' => '123',
            'zip' => '1227',
        ]);

        // Should redirect to admin_registration / admin_dashboard
        $response2->assertRedirect('/admin_dashboard/admin_registration');

        // Check database for admin_dashboard record
        $this->assertDatabaseHas('admins', [
            'email' => 'marc@example.com',
            'first_name' => 'Marc',
            'last_name' => 'Afable',
        ]);
    }
}

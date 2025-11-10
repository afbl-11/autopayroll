<?php

namespace Database\Seeders;

use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = Admin::first();
        DB::table('announcements')->insert([
            [
                'announcement_id' => Str::uuid(),
                'admin_id' => $admin->admin_id,
                'title' => 'System Maintenance',
                'message' => 'The system will be down for maintenance tonight from 10 PM to 12 AM.',
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDay(),
                'created_by' => 'admin-1',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'announcement_id' => Str::uuid(),
                'title' => 'Holiday Notice',
                'admin_id' => $admin->admin_id,
                'message' => 'The office will be closed on November 30 for a public holiday.',
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(6),
                'created_by' => 'admin-2',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'announcement_id' => Str::uuid(),
                'title' => 'Old Announcement',
                'admin_id' => $admin->admin_id,
                'message' => 'This is an old announcement that should be inactive.',
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(5),
                'created_by' => 'admin-1',
                'is_active' => false,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(5),
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@jobboard.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create a sample employer
        $employer = \App\Models\User::create([
            'name' => 'John Employer',
            'email' => 'employer@jobboard.com',
            'password' => bcrypt('password'),
            'role' => 'employer',
            'email_verified_at' => now(),
        ]);

        // Create employer profile
        \App\Models\EmployerProfile::create([
            'user_id' => $employer->id,
            'company_name' => 'Tech Solutions Inc.',
            'company_description' => 'A leading technology company providing innovative solutions.',
            'website' => 'https://techsolutions.com',
            'industry' => 'Technology',
            'company_size' => '50-100',
            'city' => 'Lagos',
            'state' => 'Lagos',
            'country' => 'Nigeria',
        ]);

        // Create a sample job seeker
        \App\Models\User::create([
            'name' => 'Jane Job Seeker',
            'email' => 'jobseeker@jobboard.com',
            'password' => bcrypt('password'),
            'role' => 'job_seeker',
            'email_verified_at' => now(),
            'bio' => 'Experienced software developer looking for new opportunities.',
        ]);
    }
}

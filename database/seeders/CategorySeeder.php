<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Software development, IT, and tech-related jobs',
                'icon' => 'fas fa-laptop-code',
                'is_active' => true,
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Digital marketing, content, and advertising roles',
                'icon' => 'fas fa-bullhorn',
                'is_active' => true,
            ],
            [
                'name' => 'Sales',
                'slug' => 'sales',
                'description' => 'Sales representatives, account managers, and business development',
                'icon' => 'fas fa-chart-line',
                'is_active' => true,
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'UI/UX design, graphic design, and creative roles',
                'icon' => 'fas fa-palette',
                'is_active' => true,
            ],
            [
                'name' => 'Finance',
                'slug' => 'finance',
                'description' => 'Accounting, financial analysis, and banking jobs',
                'icon' => 'fas fa-dollar-sign',
                'is_active' => true,
            ],
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'description' => 'Medical, nursing, and healthcare administration',
                'icon' => 'fas fa-heartbeat',
                'is_active' => true,
            ],
            [
                'name' => 'Education',
                'slug' => 'education',
                'description' => 'Teaching, training, and educational roles',
                'icon' => 'fas fa-graduation-cap',
                'is_active' => true,
            ],
            [
                'name' => 'Customer Service',
                'slug' => 'customer-service',
                'description' => 'Support, help desk, and customer relations',
                'icon' => 'fas fa-headset',
                'is_active' => true,
            ],
            [
                'name' => 'Human Resources',
                'slug' => 'human-resources',
                'description' => 'HR, recruitment, and people operations',
                'icon' => 'fas fa-users',
                'is_active' => true,
            ],
            [
                'name' => 'Operations',
                'slug' => 'operations',
                'description' => 'Operations management, logistics, and supply chain',
                'icon' => 'fas fa-cogs',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}

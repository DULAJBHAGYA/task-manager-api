<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'E-commerce Website Redesign',
                'description' => 'Complete redesign of the client\'s e-commerce platform with modern UI/UX',
                'client_name' => 'TechCorp Solutions',
                'status' => 'active',
                'start_date' => '2024-01-15',
                'end_date' => '2024-03-30',
            ],
            [
                'name' => 'Social Media Campaign',
                'description' => 'Launch a comprehensive social media marketing campaign across all platforms',
                'client_name' => 'Fashion Forward',
                'status' => 'active',
                'start_date' => '2024-02-01',
                'end_date' => '2024-04-15',
            ],
            [
                'name' => 'Brand Identity Package',
                'description' => 'Create complete brand identity including logo, color palette, and guidelines',
                'client_name' => 'StartupXYZ',
                'status' => 'completed',
                'start_date' => '2023-11-01',
                'end_date' => '2023-12-15',
            ],
            [
                'name' => 'Content Marketing Strategy',
                'description' => 'Develop and implement content marketing strategy for B2B client',
                'client_name' => 'Business Solutions Inc',
                'status' => 'on_hold',
                'start_date' => '2024-01-10',
                'end_date' => '2024-05-01',
            ],
            [
                'name' => 'Mobile App Launch',
                'description' => 'Marketing campaign for new mobile application launch',
                'client_name' => 'AppVenture',
                'status' => 'active',
                'start_date' => '2024-02-15',
                'end_date' => '2024-06-30',
            ],
        ];

        foreach ($projects as $project) {
            $project['user_id'] = 1; // Assign to user ID 1
            Project::create($project);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Project;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();
        
        if ($projects->isEmpty()) {
            $this->command->info('No projects found. Please run ProjectSeeder first.');
            return;
        }

        $tasks = [
            // E-commerce Website Redesign tasks
            [
                'project_id' => $projects->where('name', 'E-commerce Website Redesign')->first()->id,
                'title' => 'Wireframe Design',
                'description' => 'Create wireframes for all main pages of the e-commerce site',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-01-25',
                'completed_at' => '2024-01-24',
            ],
            [
                'project_id' => $projects->where('name', 'E-commerce Website Redesign')->first()->id,
                'title' => 'UI/UX Design',
                'description' => 'Design modern UI/UX for the e-commerce platform',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => '2024-02-15',
            ],
            [
                'project_id' => $projects->where('name', 'E-commerce Website Redesign')->first()->id,
                'title' => 'Frontend Development',
                'description' => 'Implement the frontend design using React',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-03-01',
            ],
            [
                'project_id' => $projects->where('name', 'E-commerce Website Redesign')->first()->id,
                'title' => 'Backend Integration',
                'description' => 'Integrate frontend with existing backend APIs',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-03-15',
            ],

            // Social Media Campaign tasks
            [
                'project_id' => $projects->where('name', 'Social Media Campaign')->first()->id,
                'title' => 'Content Calendar Creation',
                'description' => 'Create a comprehensive content calendar for all social platforms',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-02-05',
                'completed_at' => '2024-02-04',
            ],
            [
                'project_id' => $projects->where('name', 'Social Media Campaign')->first()->id,
                'title' => 'Visual Content Creation',
                'description' => 'Create engaging visual content for Instagram and Facebook',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => '2024-02-20',
            ],
            [
                'project_id' => $projects->where('name', 'Social Media Campaign')->first()->id,
                'title' => 'Influencer Outreach',
                'description' => 'Identify and reach out to relevant influencers',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-03-01',
            ],

            // Brand Identity Package tasks
            [
                'project_id' => $projects->where('name', 'Brand Identity Package')->first()->id,
                'title' => 'Logo Design',
                'description' => 'Create primary and secondary logo variations',
                'status' => 'completed',
                'priority' => 'urgent',
                'due_date' => '2023-11-15',
                'completed_at' => '2023-11-14',
            ],
            [
                'project_id' => $projects->where('name', 'Brand Identity Package')->first()->id,
                'title' => 'Color Palette Development',
                'description' => 'Develop brand color palette and guidelines',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2023-11-25',
                'completed_at' => '2023-11-24',
            ],
            [
                'project_id' => $projects->where('name', 'Brand Identity Package')->first()->id,
                'title' => 'Brand Guidelines Document',
                'description' => 'Create comprehensive brand guidelines document',
                'status' => 'completed',
                'priority' => 'medium',
                'due_date' => '2023-12-10',
                'completed_at' => '2023-12-09',
            ],

            // Content Marketing Strategy tasks
            [
                'project_id' => $projects->where('name', 'Content Marketing Strategy')->first()->id,
                'title' => 'Audience Research',
                'description' => 'Conduct detailed audience research and persona development',
                'status' => 'completed',
                'priority' => 'high',
                'due_date' => '2024-01-20',
                'completed_at' => '2024-01-19',
            ],
            [
                'project_id' => $projects->where('name', 'Content Marketing Strategy')->first()->id,
                'title' => 'Content Strategy Development',
                'description' => 'Develop comprehensive content marketing strategy',
                'status' => 'pending',
                'priority' => 'high',
                'due_date' => '2024-02-15',
            ],

            // Mobile App Launch tasks
            [
                'project_id' => $projects->where('name', 'Mobile App Launch')->first()->id,
                'title' => 'App Store Optimization',
                'description' => 'Optimize app store listings for better visibility',
                'status' => 'in_progress',
                'priority' => 'high',
                'due_date' => '2024-03-01',
            ],
            [
                'project_id' => $projects->where('name', 'Mobile App Launch')->first()->id,
                'title' => 'Launch Campaign Materials',
                'description' => 'Create promotional materials for app launch',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-03-15',
            ],
            [
                'project_id' => $projects->where('name', 'Mobile App Launch')->first()->id,
                'title' => 'Press Release',
                'description' => 'Write and distribute press release for app launch',
                'status' => 'pending',
                'priority' => 'medium',
                'due_date' => '2024-04-01',
            ],
        ];

        foreach ($tasks as $task) {
            $task['user_id'] = 1; // Assign to user ID 1
            Task::create($task);
        }
    }
}

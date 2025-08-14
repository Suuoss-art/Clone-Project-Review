<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectPersonel;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users
        $pm = User::where('role', 'pm')->first();
        $staff = User::where('role', 'staff')->first();
        $hod = User::where('role', 'hod')->first();

        // Create sample projects
        $projects = [
            [
                'judul' => 'Sistem Manajemen Inventory',
                'nilai' => 50000000,
                'pm' => 'Project Manager',
                'status' => 'Ongoing',
                'pm_id' => $pm->id,
                'status_dokumen' => 'Belum Diajukan',
                'status_komisi' => 'Belum Disetujui'
            ],
            [
                'judul' => 'Aplikasi Mobile E-Commerce',
                'nilai' => 75000000,
                'pm' => 'Project Manager',
                'status' => 'Planning',
                'pm_id' => $pm->id,
                'status_dokumen' => 'Belum Diajukan',
                'status_komisi' => 'Belum Disetujui'
            ]
        ];

        foreach ($projects as $projectData) {
            $project = Project::create($projectData);

            // Add project personnel
            ProjectPersonel::create([
                'project_id' => $project->id,
                'user_id' => $pm->id,
                'nama' => $pm->name,
                'role' => 'Project Manager'
            ]);

            ProjectPersonel::create([
                'project_id' => $project->id,
                'user_id' => $staff->id,
                'nama' => $staff->name,
                'role' => 'Developer'
            ]);

            ProjectPersonel::create([
                'project_id' => $project->id,
                'user_id' => $hod->id,
                'nama' => $hod->name,
                'role' => 'Supervisor'
            ]);
        }
    }
}

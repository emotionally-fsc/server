<?php

use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 10 Projects
        factory(\Emotionally\Project::class, 10)
            ->create()
            ->each(function ($project) {
                // For each project, create 3 subprojects
                $project->sub_projects()->saveMany(factory(\Emotionally\Project::class, 3)
                    ->create([
                        'user_id' => $project['user_id']
                    ])
                    ->each(function ($sub_project) {
                        // For each subprojects create 5 videos
                        $sub_project->videos()->saveMany(factory(\Emotionally\Video::class, 5)->make([
                            'user_id' => $sub_project['user_id'],
                            'project_id' => $sub_project['id'],
                        ]));
                    }));

                // For each project create 3 videos
                $project->videos()->saveMany(factory(\Emotionally\Video::class, 3)->make([
                    'user_id' => $project['user_id'],
                    'project_id' => $project['id'],
                ]));
            });
    }
}

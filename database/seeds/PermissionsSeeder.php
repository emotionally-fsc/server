<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // For all the stored projects...
        \Emotionally\Project::all()->each(function ($project) {
            // Get a random ammount of users and get their ids
            $users = \Emotionally\User::all()->random(rand(1, 3))->pluck('id')->toArray();

            // For each user's id generate a random set of permissions
            $permissions = array();
            foreach ($users as $id) {
                array_push($permissions, [
                    'read' => 1,
                    'modify' => (bool)rand(0, 1),
                    'add' => (bool)rand(0, 1),
                    'remove' => (bool)rand(0, 1),
                ]);
            }

            // Store the combinations of users-permissions for all the projects
            $project->users()->attach(
                array_combine($users, $permissions)
            );
        });
    }
}

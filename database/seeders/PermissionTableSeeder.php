<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $createTasks = new Permission();
        $createTasks->slug = 'create-users';
        $createTasks->name = 'Create Users';
        $createTasks->save();

        $deleteTasks = new Permission();
        $deleteTasks->slug = 'delete-users';
        $deleteTasks->name = 'Delete Users';
        $deleteTasks->save();

        $viewUsers = new Permission();
        $viewUsers->slug = 'view-users';
        $viewUsers->name = 'View Users';
        $viewUsers->save();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $dev_role = new Role();
        $dev_role->slug = 'admin';
        $dev_role->name = 'Site Administrator';
        $dev_role->save();

        $manager_role = new Role();
        $manager_role->slug = 'manager';
        $manager_role->name = 'Manager';
        $manager_role->save();

        $manager_role = new Role();
        $manager_role->slug = 'hr';
        $manager_role->name = 'HR';
        $manager_role->save();
    }
}

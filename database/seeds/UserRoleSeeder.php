<?php

use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'slug' => 'admin', 'description' => 'Admin account'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Marketing account'],
            ['name' => 'Artist', 'slug' => 'artist', 'description' => 'Graphic Designer account'],
            ['name' => 'Substrate', 'slug' => 'substrate', 'description' => 'Substrate account'],
            ['name' => 'Laser', 'slug' => 'marketing', 'laser' => 'Laser account'],
            ['name' => 'Sales', 'slug' => 'sales', 'description' => 'Sales account'],
        ]);
    }
}

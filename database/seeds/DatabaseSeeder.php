<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call([
            UserRoleSeeder::class,
        ]);

        User::create([
            'name' => 'Jorem Belen',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin@admin.com'),
        ]);
    }
}

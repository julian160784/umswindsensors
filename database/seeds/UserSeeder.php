<?php

use Illuminate\Database\Seeder;
use \App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::where('name', 'admin')->first();

        if ($admin) return;

        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('bismillah'),
            'role' => 1,
            'active' => 1
        ]);
    }
}

<?php

use App\Eloquent\Auth\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'SuperAdmin@admin.mail',
            'password' => Hash::make('Super Admin'),
        ]);
        $superAdmin->assignRole('super_admin');
    }
}

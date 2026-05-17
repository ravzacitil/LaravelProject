<?php
// ─────────────────────────────────────────────────────────────────────────────
// FILE: database/seeders/UserSeeder.php
// ─────────────────────────────────────────────────────────────────────────────
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@nexusshop.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'James Anderson',
            'email'    => 'customer@nexusshop.com',
            'password' => Hash::make('password'),
            'role'     => 'customer',
            'phone'    => '+1 555 234 5678',
            'address'  => '742 Evergreen Terrace',
            'city'     => 'Springfield',
            'country'  => 'United States',
            'postal_code' => '62701',
        ]);
    }
}

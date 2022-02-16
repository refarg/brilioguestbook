<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::updateOrCreate([
            'email'         => 'admin@brilio.net',
        ], [
            'first_name'        => 'Brilio',
            'last_name'         => 'Admin',
            'role_id'           => 1,
            'password'          => bcrypt('secret'),
        ]);
    }
}

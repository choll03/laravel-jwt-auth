<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Internal;
use App\Models\Hotel;

class AuthTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'User',
            'email'     => 'user@user.com',
            'password'  => bcrypt('user')
        ]);
        
        Internal::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'password'  => bcrypt('admin')
        ]);

        Hotel::create([
            'name'      => 'hotel',
            'email'     => 'hotel@hotel.com',
            'password'  => bcrypt('hotel')
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

// composer require laracasts/testdummy
use App\Models\User;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
           'name' => 'dondraper',
            'password' => bcrypt('password'),
            'email' => 'info@empathynyc.com'
        ]);

    }
}

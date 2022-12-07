<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'Admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'verified'           => 1,
                'verified_at'        => '2022-12-07 02:25:43',
                'verification_token' => '',
                'two_factor_code'    => '',
                'phone'              => '',
                'linkedin'           => '',
                'facebook'           => '',
                'whatsapp'           => '',
                'twitter'            => '',
                'website'            => '',
            ],
        ];

        User::insert($users);
    }
}

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
                'email_verified_at' => now(),
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
                        [
                'id'                => 2,
                'name'              => 'Manager',
                'email'             => env('APP_TEST_MANAGER_MAIL'),
                'password'          => bcrypt('password'),
                'remember_token'    => null,
                'email_verified_at' => now(),
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
            [
                'id'                => 3,
                'name'              => 'Test Staff',
                'email'             => env('APP_TEST_STAFF_MAIL'),
                'password'          => bcrypt('password'),
                'remember_token'    => null,
                'email_verified_at' => now(),
                'verified'           => 1,
                'verified_at'        => '2022-12-07 02:25:43',
                'phone'             => '',
                'verification_token' => '',
                'two_factor_code'    => '',
                'linkedin'           => '',
                'facebook'           => '',
                'whatsapp'           => '',
                'twitter'            => '',
                'website'            => '',
            ],
            [
                'id'                => 4,
                'name'              => 'Test User',
                'email'             => env('APP_TEST_USER_MAIL'),
                'password'          => bcrypt('password'),
                'remember_token'    => null,
                'email_verified_at' => now(),
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

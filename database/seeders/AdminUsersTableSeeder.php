<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name'           => 'John Doe',
            'email'          => 'super_admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password'       => bcrypt(config('permissions.passwords.admin')),
            'remember_token' => Str::random(10),
            'role' => UserRoleEnum::ADMIN->value
        ]);
    }
}

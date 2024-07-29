<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Repositories\UsersRepository;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * @var UsersRepository
     */
    private $repository;

    public function __construct(UsersRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run()
    {
        $this->repository->create([
            'name'           => 'John Doe',
            'email'          => 'super_admin@gmail.com',
            'login'          => 'superadmin',
            'email_verified_at' => Carbon::now(),
            'password'       => bcrypt(config('permission.passwords.superadmin')),
            'remember_token' => Str::random(10),
            'role' => UserRoleEnum::ADMIN->value
        ]);
    }
}

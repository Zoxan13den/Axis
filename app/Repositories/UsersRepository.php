<?php

namespace App\Repositories;

use App\Models\User;

class UsersRepository extends AbstractRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }
}
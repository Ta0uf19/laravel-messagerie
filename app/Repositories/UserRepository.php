<?php

namespace App\Repositories;

use App\User;

class UserRepository
{
    private $user; //model user

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {
        return $this->user->all();
    }

    public function findById(int $id)
    {
        return $this->user->find($id);
    }

    public function update($id, array $attributes)
    {
        return $this->user->where(['id' => $id])->update($attributes);
    }
}

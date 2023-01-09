<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserInterface
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createUser(array $attributes): Model
    {
        return $this->user->create($attributes);
    }

    public function getUser(array $attributes = []): ?Model
    {
        $query = $this->user;
        if (count($attributes) > 0){
            $query = $query->where($attributes);
        }
        return $query->first();
    }

    public function updateUser(int $id,array $attributes): bool
    {
        $user = $this->user->find($id);
        return $user->update($attributes);
    }
}

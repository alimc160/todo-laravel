<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface UserInterface
{
    public function createUser(array $attributes): Model;

    public function getUser(array $attributes): ?Model;

    public function updateUser(int $id,array $attributes): bool;
}

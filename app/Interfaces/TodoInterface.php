<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface TodoInterface
{
    public function getTodoList(int $userId,string $searchValue, int $limit): LengthAwarePaginator;
    public function createTodo(array $attributes): Model;

    public function getTodo(int $userId,int $id): ?Model;

    public function updateTodo(int $id,array $attributes);

    public function deleteTodo(int $id);
}

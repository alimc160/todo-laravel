<?php

namespace App\Repositories;

use App\Interfaces\TodoInterface;
use App\Models\Todo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class TodoRepository implements TodoInterface
{
    /**
     * @var Todo
     */
    private $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * @param array $attributes
     * @return Model
     */
    public function createTodo(array $attributes): Model
    {
        return $this->todo->create($attributes);
    }

    /**
     * @param int $userId
     * @param string|null $searchValue
     * @param int $limit
     * @return LengthAwarePaginator
     */
    public function getTodoList(int $userId, string $searchValue = null,int $limit = 15): LengthAwarePaginator
    {
        $query = $this->todo->where('user_id',$userId);
        if (isset($searchValue)){
            $query = $query->where('title','LIKE','%'.$searchValue.'%');
        }
        return $query->paginate($limit);
    }

    public function getTodo(int $userId, int $id): ?Model
    {
        return $this->todo->where('user_id',$userId)
            ->where('id',$id)->first(['title','description']);
    }

    public function updateTodo(int $id,array $attributes)
    {
       return $this->todo->findOrFail($id)->update($attributes);
    }

    public function deleteTodo(int $id)
    {
        return $this->todo->find($id)->delete();
    }
}

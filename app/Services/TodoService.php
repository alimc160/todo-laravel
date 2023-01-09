<?php

namespace App\Services;

use App\Interfaces\TodoInterface;
use App\Traits\ApiResponseTrait;

class TodoService
{
    use ApiResponseTrait;
    /**
     * @var TodoInterface
     */
    private $todoRepository;

    public function __construct(TodoInterface $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    public function getList($user,$requestData)
    {
        $userId = $user->id;
        $name = $requestData['name'] ?? null;
        $limit = $requestData['limit'] ?? 15;
        $data = $this->todoRepository->getTodoList($userId,$name,$limit);
        return [
            'items' => $data->getCollection(),
            'pagination' => paginationData($data)
        ];
    }

    public function addItem($user,$requestData)
    {
       return $this->todoRepository->createTodo([
           'user_id' => $user->id,
           'title' => $requestData['title'],
           'description' => $requestData['description']
       ]);
    }

    public function getItem($user,$id)
    {
        $userId = $user->id;
        $todo = $this->todoRepository->getTodo($userId,$id);
        if (!$todo){
            $this->errorResponse(404,'Record not exist.');
        }
        return $todo;
    }

    public function updateItem($id,$requestData)
    {
        return $this->todoRepository->updateTodo($id,$requestData);
    }

    public function deleteItem($id)
    {
        return $this->todoRepository->deleteTodo($id);
    }
}

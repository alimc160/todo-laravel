<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TodoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class TodoController extends Controller
{
    /**
     * @var TodoService
     */
    private $todoService;

    public function __construct(TodoService $todoService)
    {
        $this->todoService = $todoService;
    }

    public function getTodoListing(Request $request)
    {
        $user = $request->user();
        $input = $request->all();
        $response = $this->todoService->getList($user,$input);
        return $this->successResponse(200,'',$response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTodo(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required'
        ]);
        $input = $request->all();
        $user = $request->user();
        $response = $this->todoService->addItem($user,$input);
        return $this->successResponse(200,'Todo created successfully.',$response);
    }

    public function getTodo(Request $request,$id)
    {
        $user = $request->user();
        return $this->todoService->getItem($user,$id);
    }

    public function updateTodo(Request $request,$id)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required'
        ]);
        $input = $request->all();
        $this->todoService->updateItem($id,$input);
        return $this->successResponse(200,'Record updated successfully.');
    }

    public function deleteTodo($id)
    {
        $this->todoService->deleteItem($id);
        return $this->successResponse(200,'Record deleted successfully.');
    }
}

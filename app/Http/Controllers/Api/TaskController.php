<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'response' => 101,
            'data' => $tasks
        ]);
    }

     public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'priority' => 'required',
            'due_date' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null,
            ], 422);
        }
    
        $task = new Task();
        $task->title = $request->title;   
        $task->description = $request->description;   
        $task->priority = $request->priority;   
        $task->due_date = $request->due_date;   
        $task->save();
    
        return response()->json([
            'response' => 101,
            'message' => 'Task added successfully',
            'validation_errors' => null,
            'data' => $task,
        ]);
    }

    public function update(Request $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'priority' => 'required',
            'due_date' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null,
            ], 422);
        }
        $task = Task::find($id);

        $task->title = $request->title;   
        $task->description = $request->description;   
        $task->priority = $request->priority;   
        $task->due_date = $request->due_date;   
        $task->save();
    
        return response()->json([
            'response' => 101,
            'message' => 'Task updated successfully',
            'validation_errors' => null,
            'data' => $task,
        ]);
    }

    public function delete($id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'response' => 103,
                'message' => 'Task not found',
                'data' => null,
            ], 404);
        }
        $task->delete();

        return response()->json([
            'response' => 104,
            'message' => 'Task deleted successfully',
            'data' => null,
        ]);
    }

    public function status(Request $request , $id)
    {
        $task = Task::find($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 102,
                'message' => 'Bad Request',
                'validation_errors' => $validator->errors(),
                'data' => null,
            ], 422);
        }

        $task->status = $request->status;
        $task->save();
        return response()->json([
            'response' => 104,
            'message' => 'Task status updated successfully',
            'data' => $task,
        ]);
    }

    public function filter($status)
    {
        if ($status == 'all') {
            $tasks = Task::all();
        } else {
            $tasks = Task::where('status', $status)->get();
        }
    
        return response()->json([
            'response' => 101,
            'data' => $tasks,
        ]);
    }
    
    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('admin.sections.task.index',[
            'title' => 'Tasks',
            'menu_active' => 'task',
            'nav_sub_menu' => '',
            'tasks' => $tasks,

        ]);
    }

    public function create()
    {
        return view('admin.sections.task.create',[
            'title' => 'Tasks',
            'menu_active' => 'task',
            'nav_sub_menu' => '',
            'priorities' => Task::$priorities,
        ]);
    }

    public function store(Request $request)
    {
       $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'priority' => 'required',
        'due_date' => 'required',
       ]);  

       $task = new Task();
       $task->title = $request->title;   
       $task->description = $request->description;   
       $task->priority = $request->priority;   
       $task->due_date = $request->due_date;   
       $task->save();
       return redirect()->route('admin.tasks')->with('success' , 'Task saved successfully');
    }

    public function edit(Task $task)
    {
        return view('admin.sections.task.edit',[
            'title' => 'Tasks',
            'menu_active' => 'task',
            'nav_sub_menu' => '',
            'priorities' => Task::$priorities,
            'task' => $task,
        ]);
    }

    public function update(Request $request , Task $task)
    {
       $request->validate([
        'title' => 'required',
        'description' => 'nullable',
        'priority' => 'required',
        'due_date' => 'required',
        'status' => 'nullable',
       ]);  

       $task->title = $request->title;   
       $task->description = $request->description;   
       $task->priority = $request->priority;   
       $task->due_date = $request->due_date;   
       $task->status = $request->status;   
       $task->save();
       return redirect()->route('admin.tasks')->with('success' , 'Task saved successfully');
    }
    

    public function delete(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully');
    }

}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($group)
    {
        
        $tasks = Task::where('group_id', $group)->get();
        $executors = [];
        
        foreach ($tasks as $task) {
            $executors[$task->id] = User::find($task->executor);
        }

        return view('tasks.index', ['tasks' => $tasks, 'group' => $group, 'executors' => $executors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($group)
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $group)
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'title' => ['string', 'required', 'min:1', 'max:50'],
            'description' => ['string', 'nullable', 'max:500'],
            'deadline' => ['date', 'required'],
        ]);

        $task = new Task($validated);
        $task->group_id = $group;
        $task->executor = $user_id;

        $task->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($group, $task)
    {
        $task = Task::findOrFail($task);

        return view('tasks.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($group, $task)
    {
        $task = Task::findOrFail($task);

        return view('tasks.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $group, $task)
    {
        $task = Task::findOrFail($task);

        $validated = $request->validate([
            'title' => ['string', 'required', 'min:1', 'max:50'],
            'description' => ['string', 'nullable', 'max:500'],
            'deadline' => ['date', 'required'],
        ]);

        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->deadline = $validated['deadline'];

        $task->update();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($group, $task)
    {
        $task = Task::findOrFail($task);

        $task->delete();

        return back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Group;
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
        $executor = User::find($task->executor);
        $members = Group::find($group)->users;

        foreach ($members as $index => $user) {
            if ($user->id == $executor->id) {
                unset($members[$index]);
            }
        }

        return view('tasks.show', compact(['task', 'group', 'executor', 'members']));
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
            'executor' => ['string', 'required'],
        ]);


        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->deadline = $validated['deadline'];
        $task->executor = $validated['executor'];

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

        return redirect()->route('tasks.index', ['group' => $group]);
    }
}

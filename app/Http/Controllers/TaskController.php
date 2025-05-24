<?php

namespace App\Http\Controllers;

use App\Models\Comment;
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
    public function show($group_id, $task)
    {
        $task = Task::findOrFail($task);
        $executor = User::find($task->executor);
        $group = Group::findOrFail($group_id);
        $row_members = $group->users()->wherePivot('is_active', true)->get();
        $members = array();

        foreach ($row_members as $user) {
            $members[$user->id] = $user;
        }

        $comments = Comment::where('task_id', $task->id)->get();

        return view('tasks.show', compact(['task', 'group', 'executor', 'members', 'comments']));
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

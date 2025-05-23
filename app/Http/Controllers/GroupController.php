<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $groups = $user->groups()->wherePivot('is_active', true)->get();

        return view('groups.index', ['groups' => $groups]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_ids = array();

        $validated = $request->validate([
            'name' => ['string', 'required', 'min:1', 'max:50'],
            'members' => ['string', 'nullable'],
        ]);

        $members = $validated['members'] == "" ? [] : explode(' ', $validated['members']);

        $group = new Group();
        $group->name = $validated['name'];
        $group->count_members = 1;
        $group->save();
        $count = 0;

        if (!empty($members)) {

            foreach ($members as $email) {
                $user = User::where('email', $email)->first();

                if ($user !== null) {
                    $user_ids[] = $user->id;
                }

            }
        }

        $group->users()->attach($user_ids);
        $group->users()->attach(Auth::id(), ['is_active' => true]);

        $group->update();

        return redirect()->route('groups.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();

        $users_groups = $user->groups();

        foreach ($users_groups as $group) {
            if ($id == $group->id) {
                return view('groups.edit', ['group' => $group]);
            }
        }

        return abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validated = $request->validate([
            'name' => ['string', 'required', 'min:1', 'max:50'],
        ]);

        $users_groups = Auth::user()->groups();
        $group = Group::findOrFail($id);

        foreach ($users_groups as $group) {
            if ($id == $group->id) {
                $group->name = $validated['name'];
                $group->update();
            }
        }

        return abort(403);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $users_groups = Auth::user()->groups();
        $group = Group::findOrFail($id);

        foreach ($users_groups as $group) {
            if ($id == $group->id) {
                $group->delete();
            }
        }

        return abort(403);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Auth;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    public function index() {

        $user = Auth::user();
        $groups = $user->groups()->wherePivot('is_active', false)->get();

        return view('invitations.index', compact('groups'));
    }

     public function accept($group_id, Request $request) {
        
        $user = Auth::user();
        if ($request->has('accept')) {
            $user->groups()->updateExistingPivot($group_id, ['is_active' => true]);
            $group = Group::find($group_id);
            $group->count_members = $group->count_members + 1;
            $group->update();
            
            return back();
        } else {
            $user->groups()->detach($group_id);
            return back();
        }


     }
}

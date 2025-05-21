<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $user = Auth::user();

        return view('users.index', [$user]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $valideted = $request->validate([
            'email' => ['string', 'required', 'email', 'unique:users'],
            'name' => ['string', 'required', 'min:4', 'max:50'],
            'password' => ['string', 'required', 'min:5', 'max:50', 'confirmed'],
        ]);

        User::create($valideted);

        return redirect()->route('login.login');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.show', [$user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();

        return view('users.edit', [$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $real_user = Auth::user();

        if ($user->id !== $real_user->id) {
            return back()->withErrors(['msg' => 'У вас нет прав для изменения данных']);
        }

        $valideted = $request->validate([
            'email' => ['string', 'required', 'email'],
            'name' => ['string', 'required', 'min:5', 'max:50'],
            'password' => ['string', 'required', 'min:5', 'max:50'],
        ]);

        $user->update($valideted);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();

        $user->delete();

        return redirect()->route('login.login');
    }
}

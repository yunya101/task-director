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
            'email' => ['string', 'required', 'email'],
            'name' => ['string', 'required', 'min:4', 'max:50'],
            'password' => ['string', 'required', 'min:5', 'max:50'],
        ]);

        $user = new User();
        $user->name = $valideted['name'];
        $user->email = $valideted['email'];
        $user->password = bcrypt($valideted['password']);

        if ($user->save()) {
            return redirect()->route('login.login');
        }

        return back()->withErrors(['msg' => 'Такой email уже существует']);
        
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

        $user->name = $valideted['name'];
        $user->email = $valideted['email'];
        $user->password = bcrypt($valideted['password']);

        $user->update();

        return back()->with('msg', 'Успешно');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $real_user = Auth::user();
        $user = User::findOrFail($id);

        if ($user->id !== $real_user->id) {
            return back()->withErrors(['msg' => 'У вас нет прав для изменения данных']);
        }

        $user->delete();

        return redirect()->route('login.login');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index')->with('users', User::all());
    }

    public function makeAdmin($id)
    {
        $user = User::find($id);
        $user->role = 'admin';
        $user->save();
        return redirect()->route('users.index')->with('success', 'User made admin successfully.');
    }

    public function edit()
    {
        return view('users.edit')->with('user', auth()->user());
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'about' => $request->about
        ]);

        return redirect()->back()->with('success', 'User updated successfully');
    }
}

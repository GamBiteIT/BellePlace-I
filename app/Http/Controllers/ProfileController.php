<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //
    public function create(User $user)
    {
        return Inertia::render('Profile', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username'=>$user->username,
                'pic' => $user->pic ? URL::route('image', ['path' => $user->pic, 'w' => 100, 'h' => 100, 'fit' => 'crop']) : null,

            ],
        ]);
    }

    public function update(User $user)
    {

        Request::validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'username' => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable'],
            'pic' => ['nullable', 'image'],
        ]);

        $user->update(Request::only('name', 'email', 'username'));

        if (Request::file('pic')) {
            $user->update(['pic' => Request::file('pic')->store('users')]);
        }

        if (Request::get('password')) {
            $user->update(['password' => Hash::make(Request::get('password'))]);
        }

        return Redirect::back()->with('success', 'User updated.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;

class UsersController extends Controller
{
    
    public function edit(Request $request)
    {
        return view('users.edit', [
            'updating' => !is_null($request->user()),
            'user' => $request->user()
        ]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $user->name = $request->get('name');
        $user->password = Hash::make($request->get('password'));
        $user->save();

        return redirect('dashboard');
    }
}

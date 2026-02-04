<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Show list of all staff
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // 2. Store a new staff member
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Encrypt the password
        ]);

        return back()->with('success', 'New staff account created successfully!');
    }

    // 3. Delete a staff member (Optional, but useful)
    public function destroy($id)
    {
        if(auth()->id() == $id) {
            return back()->with('error', 'You cannot delete your own account!');
        }
        
        User::destroy($id);
        return back()->with('success', 'User deleted.');
    }
}
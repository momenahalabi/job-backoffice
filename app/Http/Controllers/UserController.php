<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = \App\Models\User::paginate(10);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:company-owner,job-seeker,admin',
        ]);

        \App\Models\User::create($validated);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|string|in:company-owner,job-seeker,admin',
        ]);

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage (Soft Delete).
     */
    public function destroy(\App\Models\User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User archived successfully');
    }

    /**
     * Display archived users.
     */
    public function archived()
    {
        $users = \App\Models\User::onlyTrashed()->paginate(10);

        return view('user.index', compact('users'))->with('isArchived', true);
    }

    /**
     * Restore an archived user.
     */
    public function restore(string $id)
    {
        $user = \App\Models\User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('user.archived')->with('success', 'User restored successfully');
    }
}

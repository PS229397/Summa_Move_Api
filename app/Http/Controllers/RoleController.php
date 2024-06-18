<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::all();
        $roles = Role::paginate();

        return view('role.index', compact('roles', 'users'))
            ->with('i', ($request->input('page', 1) - 1) * $roles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $role = new Role();
        $users = User::all(); // Fetch all users

        return view('role.create', compact('role', 'users')); // Pass users to the view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): RedirectResponse
    {
        Role::create($request->validated());

        return Redirect::route('roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
//    public function show(Request $request, Role $role): View
//    {
//        $user = $request->user(); // Get the currently authenticated user
//
//        return view('role.show', compact('role', 'user'));
//    }

//    public function show(Request $request, Role $role): View
//    {
//        $users = User::all()->map(function ($user) use ($role) {
//            if ($user->role_id == $role->id) {
//                return $user;
//            } else {
//                // Create a placeholder user with blank information
//                return new User([
//                    'username' => '',
//                    'email' => '',
//                    'first_name' => '',
//                    'last_name' => '',
//                ]);
//            }
//        });
//
//        return view('role.show', compact('role', 'users'));
//    }

    public function show(Role $role ): View
    {
        $users = User::all(); // Fetch all users from the database

        return view('role.show', compact('role', 'users'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role): View
    {
        $role = Role::find($role->id);
        $users = User::all();
        return view('role.edit', compact('role', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'rolename' => 'required|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
        ]);

        $role->update(['rolename' => $validatedData['rolename']]);
        $role->users()->sync($validatedData['users'] ?? []);

        return redirect()->route('roles.index');
    }

    public function destroy($id): RedirectResponse
    {
        Role::find($id)->delete();

        return Redirect::route('roles.index')
            ->with('success', 'Rollen tabel is verwijderd.');
    }
}

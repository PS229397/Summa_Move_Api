<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = Role::paginate();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request): Role
    {
        return Role::create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role): Role
    {
        return $role;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role): Role
    {
        $role->update($request->validated());

        return $role;
    }

    public function destroy(Role $role): Response
    {
        $role->delete();

        return response()->noContent();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;
use App\Traits\HasPermissionMiddleware;

class RolController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('roles');
    }

    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode(' ', $perm->name)[1] ?? 'otros';
        });

        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('successMsg', 'El rol se creó exitosamente.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode(' ', $perm->name)[1] ?? 'otros';
        });

        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('roles.edit', compact('permissions', 'role', 'rolePermissions'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        if ($role->name === 'super-admin' && $request->name !== 'super-admin') {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes cambiar el nombre del rol super-admin.');
        }

        $role->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name,
            'description' => $request->description,
        ]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('successMsg', 'El rol se actualizó exitosamente.');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'super-admin') {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes eliminar el rol super-admin.');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes eliminar un rol asignado a usuarios.');
        }

        $role->delete();

        return redirect()->route('roles.index')->with('successMsg', 'El rol se eliminó correctamente.');
    }
}

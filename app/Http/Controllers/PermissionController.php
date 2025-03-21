<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\PermissionRequest;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permissions.index|permissions.create|permissions.edit|permissions.destroy', ['only' => ['index']]);
        $this->middleware('permission:permissions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permissions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permissions.destroy', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(PermissionRequest $request)
    {
        Permission::create($request->validated());
        return redirect()->route('permissions.index')->with('successMsg', 'Permiso creado correctamente.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(PermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        return redirect()->route('permissions.index')->with('successMsg', 'Permiso actualizado correctamente.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('successMsg', 'Permiso eliminado correctamente.');
    }
}

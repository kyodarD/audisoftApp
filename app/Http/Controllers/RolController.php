<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\RoleRequest;

class RolController extends Controller
{
    function __construct()
    {
        // Middleware para verificar permisos específicos
        $this->middleware('permission:roles.index|roles.create|roles.edit|roles.destroy', ['only' => ['index']]);
        $this->middleware('permission:roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:roles.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:roles.destroy', ['only' => ['destroy']]);
    }

    public function index()
    {
        // Obtención de todos los roles
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        // Obtención de todos los permisos
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        // Crear el rol con los datos proporcionados
        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'description' => $request->description, // Guardar descripción
        ]);

        // Asignar permisos al rol
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('successMsg', 'El rol se creó exitosamente.');
    }

    public function edit(Role $role)
    {
        // Obtener permisos disponibles para editar
        $permissions = Permission::all();
        return view('roles.edit', compact('permissions', 'role'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        // Evitar cambios al nombre del rol "Administrador"
        if ($role->name === 'Administrador' && $request->name !== 'Administrador') {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes cambiar el nombre del rol de Administrador.');
        }

        // Actualizar el rol con los nuevos datos
        $role->update([
            'name' => $request->name,
            'guard_name' => 'web',
            'description' => $request->description, // Descripción
        ]);

        // Sincronizar permisos
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('roles.index')->with('successMsg', 'El rol se actualizó exitosamente.');
    }

    public function destroy(Role $role)
    {
        // No permitir eliminar el rol "Administrador"
        if ($role->name === 'Administrador') {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes eliminar el rol de Administrador.');
        }

        // No permitir eliminar un rol con usuarios asignados
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')->with('errorMsg', 'No puedes eliminar un rol asignado a usuarios.');
        }

        // Eliminar el rol
        $role->delete();

        return redirect()->route('roles.index')->with('successMsg', 'El rol se eliminó correctamente.');
    }
}

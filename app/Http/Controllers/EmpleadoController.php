<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpleadoRequest;
use App\Models\Empleado;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Muestra la lista de empleados.
     */
    public function index()
    {
        $empleados = Empleado::all();
        return view('empleados.index', compact('empleados'));
    }

    /**
     * Muestra el formulario para crear un nuevo empleado.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id'); // 🔹 Traemos roles con ID y Nombre
        $usuarios = User::all();
        return view('empleados.create', compact('roles', 'usuarios'));
    }

    /**
     * Almacena un nuevo empleado en la base de datos.
     */
    public function store(EmpleadoRequest $request)
    {
        $validatedData = $request->validated();

        // 🔹 Verificar que el usuario existe
        $usuario = User::find($validatedData['user_id']);
        if (!$usuario) {
            return redirect()->route('empleados.create')->with('errorMsg', 'El usuario seleccionado no existe.');
        }

        // 🔹 Verificar que el rol existe y obtener su nombre
        $role = Role::find($validatedData['role_id']);
        if (!$role) {
            return redirect()->route('empleados.create')->with('errorMsg', 'El rol seleccionado no existe.');
        }

        // 🔹 Crear el empleado
        $empleado = Empleado::create($validatedData);

        // 🔹 Asignar el rol al usuario usando el **NOMBRE del rol**
        $usuario->syncRoles([$role->name]);

        return redirect()->route('empleados.index')->with('successMsg', 'El empleado se guardó exitosamente.');
    }

    /**
     * Muestra el formulario para editar un empleado existente.
     */
    public function edit(Empleado $empleado)
    {
        $roles = Role::pluck('name', 'id'); // 🔹 Traemos roles con ID y Nombre
        $usuarios = User::all();
        return view('empleados.edit', compact('empleado', 'roles', 'usuarios'));
    }

    /**
     * Actualiza un empleado existente.
     */
    public function update(EmpleadoRequest $request, Empleado $empleado)
    {
        $validatedData = $request->validated();

        // 🔹 Verificar que el usuario existe
        $usuario = User::find($validatedData['user_id']);
        if (!$usuario) {
            return redirect()->route('empleados.edit', $empleado->id)->with('errorMsg', 'El usuario seleccionado no existe.');
        }

        // 🔹 Verificar que el rol existe y obtener su nombre
        $role = Role::find($validatedData['role_id']);
        if (!$role) {
            return redirect()->route('empleados.edit', $empleado->id)->with('errorMsg', 'El rol seleccionado no existe.');
        }

        // 🔹 Actualizar los datos del empleado
        $empleado->update($validatedData);

        // 🔹 Asignar el nuevo rol al usuario usando el **NOMBRE del rol**
        $usuario->syncRoles([$role->name]);

        return redirect()->route('empleados.index')->with('successMsg', 'El empleado se actualizó exitosamente.');
    }

    /**
     * Muestra los detalles de un empleado.
     */
    public function show(Empleado $empleado)
    {
        return view('empleados.show', compact('empleado'));
    }

    /**
     * Elimina un empleado.
     */
    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('successMsg', 'El empleado se eliminó exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('empleados.index')->with('errorMsg', 'Ocurrió un error al eliminar el empleado.');
        }
    }

    /**
     * Cambia el estado de un empleado (activo/inactivo).
     */
    public function cambioestadoempleado(Request $request)
    {
        $empleado = Empleado::find($request->id);
        if ($empleado) {
            $empleado->estado = $request->estado;
            $empleado->save();
            return response()->json(['success' => 'Estado actualizado correctamente.']);
        }
        return response()->json(['error' => 'Empleado no encontrado.'], 404);
    }
}

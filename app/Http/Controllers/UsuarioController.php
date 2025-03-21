<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Storage;  // Asegúrate de incluir Storage

class UsuarioController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(UsuarioRequest $request)
    {
        // Los datos ya están validados gracias a UsuarioRequest

        // Procesar imagen
        $image = $request->file('photo');  // Ajustamos el nombre del campo a 'photo'
        $slug = Str::slug($request->name);
        
        if ($image) {
            // Generar el nombre único para la imagen
            $imagename = $slug . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();

            // Almacenar la imagen en el disco 'public' en la carpeta 'photos'
            $imagePath = $image->storeAs('photos', $imagename, 'public');
        } else {
            $imagePath = null; // Si no se sube imagen, asignamos null
        }

        // Crear el usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(60),
            'photo' => $imagePath,
            'estado' => $request->input('estado', 1),  // Asignar estado por defecto si no se pasa
        ]);

        // Asignar roles si existen
        if ($request->filled('roles')) {
            $user->roles()->sync($request->roles);  // Sincronizamos los roles
        } else {
            return back()->withErrors(['roles' => 'Debes asignar al menos un rol al usuario.'])->withInput();
        }

        return redirect()->route('users.index')->with('successMsg', 'El usuario se guardó exitosamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UsuarioRequest $request, User $user)
    {
        // Validación
        $request->validated();

        // Evitar que un Administrador elimine su propio rol
        if (auth()->user()->id === $user->id && !in_array('Administrador', $request->roles ?? [])) {
            return redirect()->route('users.index')->with('errorMsg', 'No puedes eliminar tu propio rol de Administrador.');
        }

        // Actualizar los datos del usuario (excluyendo roles y contraseña)
        $user->update($request->except(['roles', 'password']));

        // Si la contraseña fue ingresada, actualizarla
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        // Sincronizar roles asignados
        $user->roles()->sync($request->roles ?? []);  // Actualizamos los roles del usuario

        // Si se sube una nueva foto, actualizamos la ruta de la imagen
        if ($request->hasFile('photo')) {
            // Eliminar la foto anterior si existe
            if ($user->photo && Storage::exists('public/' . $user->photo)) {
                Storage::delete('public/' . $user->photo);
            }

            // Subir la nueva foto
            $image = $request->file('photo');
            $imagename = Str::slug($request->name) . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('photos', $imagename, 'public');

            // Actualizar la columna 'photo' del usuario con la nueva imagen
            $user->photo = $imagePath;
            $user->save();
        }

        return redirect()->route('users.index')->with('successMsg', 'El usuario se actualizó exitosamente');
    }

    public function cambioestadouser(Request $request)
    {
        $user = User::find($request->id);
        if ($user) {
            $user->estado = $request->estado;
            $user->save();
            return response()->json(['success' => 'Estado actualizado correctamente.']);
        } else {
            return response()->json(['error' => 'Usuario no encontrado.'], 404);
        }
    }
}

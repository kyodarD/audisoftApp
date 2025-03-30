<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Requests\UsuarioRequest;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasPermissionMiddleware;

class UsuarioController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('usuarios');
    }

    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            if ($user->photo) {
                $filename = basename($user->photo);
                $user->public_url = route('imagen.usuario', $filename);
            } else {
                $user->public_url = null;
            }
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(UsuarioRequest $request)
    {
        $image = $request->file('photo');
        $slug = Str::slug($request->name);

        if ($image) {
            $imagename = $slug . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/usuarios/' . $imagename;

            Storage::disk('s3')->put($imagePath, file_get_contents($image));

            if (Storage::disk('s3')->exists($imagePath)) {
                \Log::info("✅ Imagen subida correctamente: {$imagePath}");
                $imageUrl = $imagePath;
            } else {
                \Log::error("❌ No se pudo subir imagen: {$imagePath}");
                $imageUrl = null;
            }
        } else {
            $imageUrl = null;
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'remember_token' => Str::random(60),
            'photo' => $imageUrl,
            'estado' => $request->input('estado', 1),
        ]);

        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
        $user->syncRoles($roleNames);
        $user->role_id = $request->roles[0];
        $user->save();

        return redirect()->route('users.index')->with('successMsg', 'El usuario se guardó exitosamente');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(UsuarioRequest $request, User $user)
    {
        $request->validated();

        $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();

        if (auth()->user()->id === $user->id && !in_array('super-admin', $roleNames)) {
            return redirect()->route('users.index')->with('errorMsg', 'No puedes eliminar tu propio rol de Super Admin.');
        }

        $user->update($request->except(['roles', 'password', 'photo']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        $user->syncRoles($roleNames);
        $user->role_id = $request->roles[0];
        $user->save();

        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imagename = Str::slug($request->name) . '-' . Carbon::now()->toDateString() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'public/usuarios/' . $imagename;

            Storage::disk('s3')->put($imagePath, file_get_contents($image));

            if (Storage::disk('s3')->exists($imagePath)) {
                \Log::info("✅ Imagen actualizada en S3: {$imagePath}");
                $user->photo = $imagePath;
                $user->save();
            } else {
                \Log::error("❌ Falló actualización de imagen en S3: {$imagePath}");
            }
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

    public function mostrarImagen($filename)
    {
        $path = 'public/usuarios/' . $filename;

        \Log::info("[mostrarImagen] Intentando acceder a: {$path}");

        try {
            $file = Storage::disk('s3')->get($path);
            $mime = Storage::disk('s3')->mimeType($path);

            \Log::info("[mostrarImagen] Imagen encontrada, devolviendo archivo.");

            return response($file, 200)->header('Content-Type', $mime);
        } catch (\Exception $e) {
            \Log::error("[mostrarImagen] Error al obtener imagen '{$path}': " . $e->getMessage());
            abort(404, 'Imagen no encontrada o acceso denegado.');
        }
    }
}

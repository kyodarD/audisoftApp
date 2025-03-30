<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use App\Models\Role;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Departamento;
use App\Http\Requests\EmpleadoRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Exception;
use App\Traits\HasPermissionMiddleware;
use Symfony\Component\HttpFoundation\Response;

class EmpleadoController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('empleados');
    }

    public function index()
    {
        $empleados = Empleado::with(['user', 'role', 'ciudad.departamento.pais'])->get();

        foreach ($empleados as $empleado) {
            if ($empleado->photo) {
                $filename = basename($empleado->photo);
                $empleado->public_url = route('imagen.empleado', $filename);
            } else {
                $empleado->public_url = null;
            }
        }

        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        $users = User::all();
        $roles = Role::all();
        $paises = Pais::with('departamentos.ciudads')->get();

        return view('empleados.create', compact('users', 'roles', 'paises'));
    }

    public function store(EmpleadoRequest $request)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            $validated['registradopor'] = auth()->id();

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imagename = 'empleado-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'empleados/' . $imagename;

                Storage::disk('s3')->put($path, file_get_contents($image));
                $validated['photo'] = $path;
            }

            $empleado = Empleado::create($validated);

            $user = User::find($validated['user_id']);
            $roleName = Role::find($validated['role_id'])?->name;

            if ($user && $roleName) {
                $user->syncRoles([$roleName]);
                $user->role_id = $validated['role_id'];
                $user->save();
            }

            DB::commit();

            return redirect()->route('empleados.index')->with('successMsg', 'El empleado fue registrado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar el empleado: ' . $e->getMessage());
            return redirect()->route('empleados.index')->withErrors('Ocurrió un error al guardar el empleado. Inténtelo nuevamente.');
        }
    }

    public function edit(Empleado $empleado)
    {
        $users = User::all();
        $roles = Role::all();
        $paises = Pais::with('departamentos.ciudads')->get();

        return view('empleados.edit', compact('empleado', 'users', 'roles', 'paises'));
    }

    public function update(EmpleadoRequest $request, Empleado $empleado)
    {
        $validated = $request->validated();

        try {
            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                $image = $request->file('photo');
                $imagename = 'empleado-' . uniqid() . '.' . $image->getClientOriginalExtension();
                $path = 'empleados/' . $imagename;

                Storage::disk('s3')->put($path, file_get_contents($image));
                $validated['photo'] = $path;
            }

            $empleado->update($validated);

            $user = $empleado->user;
            $roleName = Role::find($validated['role_id'])?->name;

            if ($user && $roleName) {
                $user->syncRoles([$roleName]);
                $user->role_id = $validated['role_id'];
                $user->save();
            }

            DB::commit();

            return redirect()->route('empleados.index')->with('successMsg', 'El empleado fue actualizado exitosamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el empleado: ' . $e->getMessage());
            return redirect()->route('empleados.index')->withErrors('Ocurrió un error al actualizar el empleado. Inténtelo nuevamente.');
        }
    }

    public function destroy(Empleado $empleado)
    {
        try {
            $empleado->delete();
            return redirect()->route('empleados.index')->with('successMsg', 'El empleado fue eliminado exitosamente.');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el empleado: ' . $e->getMessage());
            return redirect()->route('empleados.index')->withErrors('No se puede eliminar este empleado porque tiene información relacionada.');
        } catch (Exception $e) {
            Log::error('Error inesperado al eliminar el empleado: ' . $e->getMessage());
            return redirect()->route('empleados.index')->withErrors('Ocurrió un error inesperado. Comuníquese con el Administrador.');
        }
    }

    public function show(Empleado $empleado)
    {
        $empleado->load('user', 'ciudad.departamento.pais', 'role');
        return view('empleados.show', compact('empleado'));
    }

    public function mostrarImagen($filename)
    {
        $path = 'empleados/' . $filename;

        try {
            if (!Storage::disk('s3')->exists($path)) {
                abort(404, 'Imagen no encontrada.');
            }

            $file = Storage::disk('s3')->get($path);
            $mime = Storage::disk('s3')->mimeType($path);

            return response($file, 200)->header('Content-Type', $mime);
        } catch (Exception $e) {
            Log::error("[mostrarImagen] Error al mostrar imagen '{$path}': " . $e->getMessage());
            return response()->json([
                'error' => 'No se pudo acceder a la imagen',
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
}

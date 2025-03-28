<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Http\Requests\ProveedorRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasPermissionMiddleware;

class ProveedorController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('proveedores');
    }

    /**
     * Muestra la lista de proveedores.
     */
    public function index()
    {
        try {
            $proveedores = Proveedor::with('usuario')->get();
            return view('proveedores.index', compact('proveedores'));
        } catch (Exception $e) {
            Log::error('Error al cargar proveedores: ' . $e->getMessage());
            return back()->withErrors('Error al cargar la lista de proveedores.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo proveedor.
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Almacena un nuevo proveedor en la base de datos.
     */
    public function store(ProveedorRequest $request)
    {
        try {
            $validated = $request->validated();
            $validated['registradopor'] = Auth::id();

            Proveedor::create($validated);

            return redirect()
                ->route('proveedores.index')
                ->with('successMsg', 'El proveedor se ha registrado exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al guardar proveedor:', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return back()
                ->withInput()
                ->withErrors('Error al guardar el proveedor. Verifique los datos e intente nuevamente.');
        }
    }

    /**
     * Muestra el formulario para editar un proveedor existente.
     */
    public function edit(Proveedor $proveedor)
    {
        try {
            return view('proveedores.edit', compact('proveedor'));
        } catch (Exception $e) {
            Log::error('Error al cargar formulario de edición:', [
                'error' => $e->getMessage(),
                'proveedor_id' => $proveedor->id
            ]);
            return back()->withErrors('Error al cargar el formulario de edición.');
        }
    }

    /**
     * Actualiza un proveedor existente.
     */
    public function update(ProveedorRequest $request, Proveedor $proveedor)
    {
        try {
            Log::info('Actualizando proveedor:', [
                'id' => $proveedor->id,
                'datos' => $request->validated()
            ]);

            $validated = $request->validated();

            if (!isset($validated['registradopor'])) {
                $validated['registradopor'] = $proveedor->registradopor;
            }

            $proveedor->update($validated);

            return redirect()
                ->route('proveedores.index')
                ->with('successMsg', 'El proveedor se ha actualizado exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al actualizar proveedor:', [
                'error' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings()
            ]);
            return back()
                ->withInput()
                ->withErrors('Error al actualizar el proveedor. Verifique los datos e intente nuevamente.');
        }
    }

    /**
     * Elimina un proveedor.
     */
    public function destroy(Proveedor $proveedor)
    {
        try {
            $proveedor->delete();
            return redirect()
                ->route('proveedores.index')
                ->with('successMsg', 'El proveedor se ha eliminado exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar proveedor:', [
                'error' => $e->getMessage(),
                'proveedor_id' => $proveedor->id
            ]);
            return back()->withErrors('No se puede eliminar el proveedor porque tiene registros relacionados.');
        }
    }

    /**
     * Cambia el estado de un proveedor (activo/inactivo).
     */
    public function cambioestadoproveedor(Request $request)
    {
        try {
            $proveedor = Proveedor::findOrFail($request->id);
            $proveedor->estado = $request->estado;
            $proveedor->save();

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            ]);
        } catch (Exception $e) {
            Log::error('Error al cambiar estado del proveedor:', [
                'error' => $e->getMessage(),
                'proveedor_id' => $request->id,
                'estado' => $request->estado
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado'
            ], 500);
        }
    }
}

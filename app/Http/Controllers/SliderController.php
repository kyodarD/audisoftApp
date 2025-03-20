<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Http\Requests\SliderRequest;
use Illuminate\Support\Facades\DB;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DragonCode\Contracts\Cache\Store;


class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::all();
        return view('sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('sliders.create');
    }

    public function store(Request $request)
{
    // Validar la entrada
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validación de imagen
    ]);

    // Crear un nuevo slider
    $slider = new Slider();
    $slider->titulo = $request->input('titulo');
    $slider->descripcion = $request->input('descripcion');

    // Guardar la imagen si está presente
    if ($request->hasFile('img')) {
        $path = $request->file('img')->store('sliders', 'public');
        $slider->img = $path;
    }

    // Asignar el ID del usuario que registró el slider
    $slider->registrado_por = auth()->user()->id; // Asegúrate de que el usuario esté autenticado

    // Guardar el registro en la base de datos
    $slider->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('sliders.index')->with('success', 'Slider creado con éxito');
}
    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
{
    // Validar la entrada
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validación de imagen
    ]);

    // Actualizar el slider con los nuevos datos
    $slider->titulo = $request->input('titulo');
    $slider->descripcion = $request->input('descripcion');

    // Guardar la imagen si está presente y eliminar la anterior si existe
    if ($request->hasFile('img')) {
        // Eliminar la imagen anterior si existe
        if ($slider->img) {
            Storage::disk('public')->delete($slider->img);
        }
        // Guardar la nueva imagen
        $path = $request->file('img')->store('sliders', 'public');
        $slider->img = $path;
    }

    // Guardar los cambios en la base de datos
    $slider->save();

    // Redireccionar con mensaje de éxito
    return redirect()->route('sliders.index')->with('success', 'Slider actualizado con éxito');
}


    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider eliminado.');
    }
}

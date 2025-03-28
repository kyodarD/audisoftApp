<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Http\Requests\SliderRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasPermissionMiddleware;

class SliderController extends Controller
{
    use HasPermissionMiddleware;

    public function __construct()
    {
        $this->applyPermissionMiddleware('sliders');
    }

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
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slider = new Slider();
        $slider->titulo = $request->input('titulo');
        $slider->descripcion = $request->input('descripcion');

        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('sliders', 'public');
            $slider->img = $path;
        }

        $slider->registrado_por = auth()->id();
        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider creado con éxito');
    }

    public function edit(Slider $slider)
    {
        return view('sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slider->titulo = $request->input('titulo');
        $slider->descripcion = $request->input('descripcion');

        if ($request->hasFile('img')) {
            if ($slider->img) {
                Storage::disk('public')->delete($slider->img);
            }

            $path = $request->file('img')->store('sliders', 'public');
            $slider->img = $path;
        }

        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider actualizado con éxito');
    }

    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', 'Slider eliminado.');
    }
}

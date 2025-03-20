<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Carrusel;
use Illuminate\Support\Str;
use Image;
use Illuminate\Database\QueryException;
use Exception;



class CarruselController extends Controller
{
    public function index(){
        $carrusels = Carrusel::all();
        return view("carrusels.index",compact('carrusels'));
    }
    public  function create(){
        return view('carrusels.index');
    }
    public  function store(Request $request){
        return view('carrusels.index');
     
    }
    public  function update(Request $request,$id){
        return view('carrusels.index');
    }
    public  function show($id){
        return view('carrusels.index');
    }
    public  function destoy($id){
        return view('carrusels.index');
    }
}

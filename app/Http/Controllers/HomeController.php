<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Docente;
use App\Models\Materia;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $contador = Docente::where('estado', 'A')->count();
        $ambientes = Docente::where('id_programa', 'SIS')->get();
        $materias = Materia::where('id_programa', 'SIS')->get();
        return view('home', compact('contador', 'ambientes', 'materias'))->with('i');
    }
    
}

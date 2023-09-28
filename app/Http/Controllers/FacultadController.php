<?php

namespace App\Http\Controllers;
use App\Models\Facultad;
use App\Models\Docente;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultadController extends Controller
{
    public function index () {
        $facultades = Facultad::all();
        return view('facultad.index', compact('facultades'))
        ->with('i');
    }
    
    public function create()
{
    $docentes = Docente::all();
    
    return view('facultad.create', compact('docentes'));
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'facultad' => 'required',
        'telefono' => 'required',
        'email' => 'required|email',
        'id_docente' => 'required',
        'autoridad' => 'required',
    ]);

    $facultad = Facultad::create($validatedData);
    return redirect('/facultades')->with('success', 'Facultad creada exitosamente');
}

   

    public function edit($id) {
        $facultad = Facultad::find($id);
        if ($id == '23') {
            $fac = Facultad::all();
            $docentes = Docente::whereIn('id_docente', $fac->pluck('id_docente'))
                  ->where('estado', 'A')
                  ->get();
            return view('facultad.edit', compact('facultad', 'docentes'));
        } else {
            $docentes = collect();
            $carreras = Carrera::where('id_facultad', $id)->with('docentes')->get();
            foreach ($carreras as $carrera) {
                $docentes = $docentes->merge($carrera->docentes);
            }
            return view('facultad.edit', compact('facultad', 'docentes'));
        }
    }
    
    
    
    public function update(Request $request, $id){
        $facultad = Facultad::find($id);
        $facultad->facultad =$request->get('facultad');
        $facultad->telefono =$request->get('telefono');
        $facultad->id_docente =$request->get('id_docente');
        $facultad->autoridad =$request->get('autoridad');
        $facultad->email =$request->get('email');
        $facultad->save();
        return redirect('facultades/');
    }
    public function destroy($id){
        $facultad = Facultad::find($id);
        $facultad->delete();
        return redirect('facultades/');
    }
}

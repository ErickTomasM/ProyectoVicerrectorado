<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Facultad;
use App\Models\Materia;
use App\Models\User;
use Collective\Html\FormFacade as Form;
use Illuminate\Support\Facades\Auth;
use App\Policies\CarreraPolicy;



class CarreraController extends Controller
{
    public function index()
{
    $user = Auth::user();
    if ($user->hasRole('Vicerrectorado')) {
        $carreras = Carrera::all();
    } else {
        $facultad_id = $user->roles->pluck('id_facultad')->first();
        if (!$facultad_id) {
            abort(403, 'No tienes una facultad asignada.');
        }
        $carreras = Carrera::where('id_facultad', $facultad_id)
                   ->where('activo', '=', 'A')
                   ->get();
                   

    }
    return view('carrera.index', compact('carreras'))->with('i');
}


    public function show(Carrera $carreras)
    {
      //
    }
    public function showDocentes($id)
    {
        $carrera = Carrera::find($id);
        $docentes = Docente::where('id_programa', $id)
                    ->where('estado', '=', 'A')
                    ->get();
    
        return view('carrera.showDocentes', compact('docentes', 'carrera'))->with('i', 1);
    }
    
public function showMaterias($id)
{
    $materias = Materia::where('id_programa', $id)
                ->get();
    $carrera = Carrera::find($id);                   
    return view('carrera.showMaterias', compact('materias', 'carrera'))->with('i');
}



    public function create(){
        $facultades = Facultad::pluck('facultad', 'id_facultad');
        return view('carrera.create', compact('facultades'));
    }
    public function store(Request $request){
        $Carrera = Carrera::create($request->all());
        return redirect('/carreras')->with('success', 'Carrera creada Exitosamente');
    }
    
    public function edit($id) {
        $carrera = Carrera::find($id);
        $facultades = Facultad::pluck('facultad', 'id_facultad');
        return view('carrera.edit', compact('carrera', 'facultades'));
    }
    public function update(Request $request, $id){
        $carrera = Carrera::find($id);
        $carrera->id_programa = $request->get('id_programa');
        $carrera->programa = $request->get('programa');
        $carrera->id_facultad = $request->get('id_facultad');
        $carrera->telefono = $request->get('telefono');
        $carrera->email = $request->get('email');
        $carrera->save();
        return redirect('carreras/',);
    }
    public function destroy($id) {
        $carrera = Carrera::find($id);
        $carrera->delete();
        return redirect('carreras/');
    }

   
}

<?php

namespace App\Http\Controllers;
use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Collective\Html\FormFacade as Form;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::all();
        return view('materia.index', compact('materias'))
        ->with('i');
    }
    

    public function create($id)
    {
        $user = Auth::user();
        if ($user->hasRole('Vicerrectorado')) {
            $carreras = Carrera::where('id_programa', $id)
                       ->pluck('programa', 'id_programa');
        } else {
            $facultad_id = $user->roles->pluck('id_facultad')->first();
            if (!$facultad_id) {
                abort(403, 'No tienes una facultad asignada.');
            }
            $carreras = Carrera::where('id_programa', $id)
                       ->where('id_facultad', $facultad_id)
                       ->pluck('programa', 'id_programa');
        }
        return view('materia.create', compact('carreras'));
    }
    

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_programa' => 'required',
        'sigla' => 'required',
        'materia' => 'required',
        'hrs_practicas' => 'required',
        'hrs_teoricas' => 'required',
    ]);

    $materia = Materia::create($validatedData);

    return redirect()->route('carreras.index')->with('success', 'Materia creada correctamente');

}

    

    public function show(Materia $materia)
    {
        return view('materias.show', compact('materia'));
    }

    public function edit($id)
    {
       $materia = Materia::find($id);
       $carreras = Carrera::pluck('programa', 'id_programa');
        return view('materia.edit', compact('materia', 'carreras'));
    }

    public function update(Request $request, $id)
    {
        $materia = Materia::find($id);
        $materia->id_programa = $request->get('id_programa');
        $materia->sigla = $request->get('sigla');
        $materia->materia = $request->get('materia');
        $materia->hrs_practicas = $request->get('hrs_practicas');
        $materia->hrs_teoricas = $request->get('hrs_teoricas');

        $materia->save();
        
        return redirect('materias/');

    }



    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('carreras.index')->with('success', 'Materia eliminada correctamente.');
    }
    public function getMateria(){
        $materias = Materia::select('nombres', 'paterno', 'materno', 'ci');
        return response()->json($docentes);
    }
}

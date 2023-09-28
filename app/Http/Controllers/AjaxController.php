<?php

namespace App\Http\Controllers;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Asignacion;
use App\Models\Designacion;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class AjaxController extends Controller
{
    public function json_docentes() {
        $docentes = Docente::select('id_docente', 'nombres', 'paterno', 'materno', 'ci', 'abre_titulo', 'tiempo', 'estado')->get();
        //return $docentes;
        return datatables()->of($docentes)->toJson();
    }
    public function json_materias() {
        $materias = Materia::select('id_materia', 'sigla', 'materia', 'hrs_teoricas', 'hrs_practicas', 'id_programa')->get();
        //return $docentes;
        return datatables()->of($materias)->toJson();
    }
    public function json_apoyo(Request $request) {
        $id_programa = $request->get('id_programa');
        $materias = Materia::where('id_programa', $id_programa)->get();
        return response()->json($materias);
    }
    


    public function view(Request $request)
{
    $materias = Materia::whereIn('id_materia', $request->input('materias'))->get();
    $designaciones = Designacion::where('id_designacion', $request->input('id_designacion'))->get();
    $grupos = $request->input('grupo');
    $data = [];
    foreach($materias as $materia) {
        foreach($grupos[$materia->id_materia] as $grupo) {
            $data[] = [
                'id_docente' => $request->input('id_docente'),
                'id_materia' => $materia->id_materia,
                'id_designacion' => $materia->id_materia,
                'grupo' => $grupo,
            ];
        }
    }
    //return response()->json(['data' => $data]);
    return view('asignaciones.index', ['data' => $data]);
}



}


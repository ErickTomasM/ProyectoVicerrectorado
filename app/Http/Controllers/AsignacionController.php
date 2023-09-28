<?php
namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Apoyo;
use App\Models\Designacion;
use App\Models\Reasignacion;
use App\Models\Asignacion;
use Illuminate\Http\Request; //recupera datos de la vista, los datos que son enviados por POST o GET
use Illuminate\Support\Facades\DB; //nos permite trabajar con la base de datos utilizando procedimientos almacenados y otros
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Policies\CarreraPolicy;

class AsignacionController extends Controller
{
    public function index()
    {
            // 
    }
    public function materias($id)
{
    $designacion = Designacion::findOrFail($id);
    $docentes = Docente::where('id_programa', $designacion->id_programa)->where('estado', '=', 'A')->get();
    $id_designacion = $id;
    
    // Obtener las materias del plan de estudios
    $materias = Materia::where('id_programa', $designacion->id_programa)
        ->where('_estado', '=', 'REGISTRADO')
        ->get();

    // Obtener las materias de apoyo
    $materiasApoyo = Apoyo::where('id_carrera', $designacion->id_programa)
        ->pluck('id_materia')
        ->all();

    // Unir las materias de apoyo al plan de estudios
    foreach ($materiasApoyo as $materiaApoyo) {
        $materia = Materia::find($materiaApoyo);
        if ($materia) {
            $materias->push($materia);
        }
    }

    $grupos = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    return view('asignacion.index', compact('designacion', 'docentes', 'materias', 'grupos'))->with('i');
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'id_docente' => 'required',
        'materias' => 'required|array|min:1',
        'periodo' => 'required|string',
    ]);

    $id_docente = $validatedData['id_docente'];
    $materias = $validatedData['materias'];
    $periodo = $validatedData['periodo'];
    $docente = Docente::where('id_docente', $id_docente)->first(['nombres', 'paterno', 'materno']);

    $asignaciones = [];
    foreach ($materias as $id_materia) {
        $grupos = $request->input('grupo_'.$id_materia);
        foreach($grupos as $grupo) {
            $duplicado = Asignacion::where('id_materia', $id_materia)
                ->where('grupo', $grupo)
                ->where('anio', $request->input('anio'))
                ->where(function ($query) use ($periodo) {
                    $query->where('periodo', $periodo)
                        ->orWhere('periodo', 'Gestión Académica');
                })
                ->exists();
            if ($duplicado) {
                return redirect()->back()->with('error', 'Error al asignar materias, la materia ya ha sido asignada a otro docente en el mismo período.');
            }

            $asignacion = new Asignacion();
            $asignacion->id_docente = $id_docente;
            $asignacion->id_materia = $id_materia;
            $asignacion->id_designacion = $request->input('id_designacion');
            $asignacion->anio = $request->input('anio');
            $asignacion->periodo = $periodo;
            $asignacion->grupo = $grupo;
            $asignacion->save();

            $materia = Materia::where('id_materia', $id_materia)->first(['sigla', 'materia', 'hrs_teoricas', 'hrs_practicas']);
            $carga_horaria_total = $materia->hrs_teoricas + $materia->hrs_practicas;

            $asignaciones[] = [
                'materia' => $materia,
                'grupo' => $grupo,
                'carga_horaria_total' => $carga_horaria_total,
            ];
        }
    }

    return redirect()->route('asignaciones.materias', $request->input('id_designacion'))
        ->with('success', [
            'docente' => $docente,
            'asignaciones' => $asignaciones,
        ]);
}




public function storeReasig(Request $request)
{
    $validatedData = $request->validate([
        'id_docente' => 'required',
        'materias' => 'required|array|min:1',
    ]);

    $id_docente = $validatedData['id_docente'];
    $materias = $validatedData['materias'];
    $docente = Docente::findOrFail($id_docente, ['nombres', 'paterno', 'materno']);
    $id_reasignacion = $request->input('id_reasignacion');
    $reasignacion = Reasignacion::findOrFail($id_reasignacion);

    $asignaciones = [];
    foreach ($materias as $id_materia) {
        $grupos = $request->input('grupo_'.$id_materia);

        foreach($grupos as $grupo) {
            $duplicado = Asignacion::where('id_materia', $id_materia)
                ->where('grupo', $grupo)
                ->where('anio', $request->input('anio'))
                ->where('periodo', $request->input('periodo'))
                ->exists();
            if ($duplicado) {
                return redirect()->back()->with('error', 'Error al asignar materias, la materia ya está asignada a otro docente en la reasignación actual');
            } 
            $asignacion = new Asignacion();
            $asignacion->id_docente = $id_docente;
            $asignacion->id_materia = $id_materia;
            $asignacion->id_reasignacion = $id_reasignacion;
            $asignacion->anio = $request->input('anio');
            $asignacion->periodo = $request->input('periodo');
            $asignacion->grupo = $grupo;
            $asignacion->save();

            $materia = Materia::findOrFail($id_materia, ['sigla', 'materia', 'hrs_teoricas', 'hrs_practicas']);
            $carga_horaria_total = $materia->hrs_teoricas + $materia->hrs_practicas;

            $asignaciones[] = [
                'materia' => $materia,
                'grupo' => $grupo,
                'carga_horaria_total' => $carga_horaria_total,
            ];
        }
    }
    return redirect()->route('reasignaciones.materias', ['id_reasignacion' => $id_reasignacion, 'id_docente' => $id_docente])
        ->with('success', [
            'docente' => $docente,
            'asignaciones' => $asignaciones,
        ]);
}


    
    


public function show() {
    $user = Auth::user();
    if ($user->hasRole('Vicerrectorado')) {
        $carreras = Carrera::where('activo', '=', 'A')->get();
        $designaciones = Designacion::all();
    } else {
        $facultad_id = $user->roles->pluck('id_facultad')->first();
        if (!$facultad_id) {
            abort(403, 'No tienes una facultad asignada.');
        }
        $carreras = Carrera::where('id_facultad', $facultad_id)
                   ->where('activo', '=', 'A')
                   ->get();
        $programas = $carreras->pluck('id_programa');
        $designaciones = Designacion::whereIn('id_programa', $programas)->get();
    }

    return view('asignacion.show', compact('carreras', 'designaciones'));
}
   
public function ver(Request $request)
{
    $id_carrera = $request->input('id_carrera');
    $periodo = $request->input('periodo');
    $gestion = $request->input('gestion');

    $carrera = Carrera::where('id_programa', $id_carrera)
                ->pluck('programa');

    $asignaciones = Asignacion::whereHas('materia', function ($query) use ($id_carrera) {
        $query->where('id_programa', $id_carrera);
    })->whereHas('designacion', function ($query) use ($periodo) {
        $query->where('periodo', $periodo);
    })->whereHas('designacion', function ($query) use ($gestion) {
        $query->where('anio', $gestion);
    })->get();

    return view('asignacion/ver', compact('asignaciones', 'id_carrera', 'periodo', 'gestion', 'carrera'))->with('i');
}

public function deleteMateria($id)
{
    $asignacion = Asignacion::find($id);

    if ($asignacion) {
        $asignacion->delete();
        return back()->with('success', 'Asignación eliminada exitosamente.');
    } else {
        return back()->with('error', 'La eliminacion fue cancelada');
    }
}




       
} 
   


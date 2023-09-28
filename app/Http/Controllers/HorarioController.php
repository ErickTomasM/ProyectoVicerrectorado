<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Designacion;
use App\Models\Horario;
use App\Models\AmbienteCarrera;
use App\Models\Ambiente;
use App\Models\Bloque;
use App\Models\Campus;
use App\Models\Asignacion;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Policies\CarreraPolicy;
use Dompdf\Dompdf;
use PDF;

class HorarioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Vicerrectorado')) {
            $carreras = Carrera::where('activo', '=', 'A')->get();
            $designaciones = Designacion::all();
            $anioActual = date('Y');
            $anio = range($anioActual, $anioActual+10);
        } else {
            $facultad_id = $user->roles->pluck('id_facultad')->first();
            if (!$facultad_id) {
                abort(403, 'No tienes una facultad asignada.');
            }
            $carreras = Carrera::where('id_facultad', $facultad_id)
                       ->where('activo', '=', 'A')
                       ->get();
                   
        $designaciones = Designacion::whereHas('carrera', function($query) use ($facultad_id) {
                    $query->where('id_facultad', $facultad_id);
                    })
                    ->get();
        $anioActual = date('Y');
        $anio = range($anioActual, $anioActual+10);
    }
    return view('horario.index', compact('carreras', 'designaciones', 'anio', 'anioActual'))->with('i');
    }

    public function showVer(Request $request)
    {
        $id_carrera = $request->input('id_carrera');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
        
        $carrera = Carrera::where('id_programa', $id_carrera)
            ->pluck('programa');
        
        $designacion = Designacion::where('id_programa', $id_carrera)
            ->where('anio', $gestion)
            ->where('periodo', $periodo)
            ->firstOrFail();
        
        $docentes = [];
        $asignaciones = Asignacion::whereHas('designacion', function ($query) use ($id_carrera, $gestion, $periodo) {
                $query->where('id_programa', $id_carrera)
                      ->where('anio', $gestion)
                      ->where('periodo', $periodo);
            })
            ->get();
        
        if ($request->has('docente_id')) {
            $docente_id = $request->input('docente_id');
            $asignaciones = $asignaciones->where('id_docente', $docente_id);
            $docente = Docente::findOrFail($docente_id);
            $docentes[$docente->id_docente] = $docente->nombres.' '.$docente->paterno.' '.$docente->materno;
        } else {
            foreach ($asignaciones as $asignacion) {
                $docente = $asignacion->docente;
                $docentes[$docente->id_docente] = $docente->nombres.' '.$docente->paterno.' '.$docente->materno;
            }
        }

        $ambiente_carrera = AmbienteCarrera::all();
        
        return view('horario.show', compact('periodo', 'gestion', 'carrera', 'docentes', 'asignaciones'));
    }
    public function show($id)
{
    $docente = Docente::findOrFail($id);
    $materias = Materia::whereHas('asignaciones', function ($query) use ($id) {
        $query->where('id_docente', $id);
    })
    ->with(['asignaciones' => function ($query) use ($id) {
        $query->where('id_docente', $id);
    }])
    ->get();

    $ambiente_carrera = AmbienteCarrera::where('id_programa', $docente->id_programa)
        ->get();

    return view('horario.horarios', compact('docente', 'materias', 'ambiente_carrera'));
}

public function store(Request $request, $id)
{
    $docente = Docente::findOrFail($id);
    $horarios = $request->input('horarios');

    foreach ($horarios as $hora => $dias) {
        foreach ($dias as $dia => $materiaId) {
            $ambienteId = $request->input('ambientes_carrera.' . $hora . '.1');

            if (!empty($materiaId) && !empty($ambienteId)) {
                $horario = new Horario();
                $horario->id_asignacion = $materiaId;
                $horario->id_ambientes_carrera = $ambienteId;
                $horario->dia_semana = $dia;
                $horario->hora_inicio = $hora;
                $horario->hora_fin = $hora + 1;
                $horario->save();
            }
        }
    }

    return redirect()->back()->with('success', 'Los horarios se han guardado correctamente.');
}
public function guardar(Request $request)
{
    $materias = $request->input('materias');
    $ambienteCarrera = $request->input('ambiente_carrera');

    // Recorrer los datos y guardar los horarios
    foreach ($materias as $hora => $dia) {
        foreach ($dia as $diaSemana => $materiaId) {
            $horaInicio = 7 + floor($hora / 2);
            $minutosInicio = $hora % 2 == 0 ? 0 : 45;
            $horaFin = $horaInicio + 1;
            $minutosFin = $minutosInicio == 0 ? 45 : 0;

            $horario = new Horario();
            $horario->id_materia = $materiaId;
            $horario->id_ambientes_carrera = $ambienteCarrera[$hora][$diaSemana];
            $horario->dia_semana = $diaSemana;
            $horario->hora_inicio = ($horaInicio * 100) + $minutosInicio;
            $horario->hora_fin = ($horaFin * 100) + $minutosFin;

            $horario->save();
        }
    }

    return redirect()->route('horarios.index')->with('success', 'Horarios guardados exitosamente');
}



    





}

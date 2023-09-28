<?php

namespace App\Http\Controllers;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Designacion;
use App\Models\Reasignacion;
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

class ReporteController extends Controller
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
    return view('reporte.index', compact('carreras', 'designaciones', 'anio', 'anioActual'))->with('i');
    }

    public function reporteGeneral(Request $request)
{
    $idCarrera = $request->input('id_carrera');
    $periodo = $request->input('periodo');
    $gestion = $request->input('gestion');

    $carrera = Carrera::findOrFail($idCarrera);
    $designaciones = Designacion::where('periodo', $periodo)
                                ->where('anio', $gestion)
                                ->where('id_programa', $idCarrera)
                                ->get();
    $asignaciones = $designaciones->flatMap(function ($designacion) {
        return $designacion->asignaciones;
    });

    return view('reporte.show', compact('carrera', 'designaciones', 'periodo', 'gestion', 'asignaciones'))->with('i');
}
public function pdfReporte($id_programa, $periodo, $gestion)
{
    $carrera = Carrera::findOrFail($id_programa);
    $designaciones = Designacion::where('periodo', $periodo)
                                ->where('anio', $gestion)
                                ->where('id_programa', $id_programa)
                                ->get();
    $asignaciones = $designaciones->flatMap(function ($designacion) {
        return $designacion->asignaciones;
    });
    $pdf = PDF::loadView('reporte.pdf', compact( 'carrera', 'designaciones', 'asignaciones', 'periodo', 'gestion'));
    return $pdf->stream();
}
    public function proveidoDesignacion() {
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
    return view('reporte.proveido', compact('carreras', 'designaciones', 'anio', 'anioActual'))->with('i');
    
    }
    public function proveidoVista(Request $request) {
        $id_carrera = $request->input('id_carrera');
        $periodo = $request->input('periodo');
        $gestion = $request->input('gestion');
    
        $carrera = Carrera::findOrFail($id_carrera);
        $designaciones = Designacion::where('periodo', $periodo)
                                    ->where('anio', $gestion)
                                    ->where('id_programa', $id_carrera)
                                    ->get();
        return view('reporte.proveidoVista', compact('carrera', 'designaciones', 'gestion', 'periodo'))->with('i');
    }
    public function proveidoPDF($id) {
        $designacion = Designacion::findOrFail($id);
        $carrera = Carrera::findOrFail($designacion->id_programa);
        $facultad = Facultad::findOrFail($carrera->id_facultad);
        $autoridad = Facultad::where('id_facultad', '=', '23')->get();
        
    
        $pdf = PDF::loadView('reporte.proveidoPDF', compact('designacion', 'carrera', 'facultad', 'autoridad'));
        return $pdf->stream();
    }
    
    
    

}

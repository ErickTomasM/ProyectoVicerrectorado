<?php
namespace App\Http\Controllers;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Designacion;
use App\Models\Reasignacion;
use App\Models\Asignacion;
use App\Models\Apoyo;
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

class ReasignacionController extends Controller
{
    public function index()
{
    $user = Auth::user();
if ($user->hasRole('Vicerrectorado')) {
    $carreras = Carrera::pluck('programa', 'id_programa');
    $reasignaciones = Reasignacion::all();
    $anioActual = date('Y');
    $anio = range($anioActual, $anioActual+10);
} else {
    $facultad_id = $user->roles->pluck('id_facultad')->first();
    if (!$facultad_id) {
        abort(403, 'No tienes una facultad asignada.');
    }
    $carreras = Carrera::where('id_facultad', $facultad_id)
               ->where('activo', '=', 'A')
               ->pluck('programa', 'id_programa');
    $anioActual = date('Y');
    $anio = range($anioActual, $anioActual+10);

    $reasignaciones = Reasignacion::whereHas('carrera', function($query) use ($facultad_id) {
        $query->where('id_facultad', $facultad_id);
        })
        ->get();
}
return view('reasignacion.index', compact('carreras', 'anio', 'anioActual', 'reasignaciones'))->with('i');
}

public function store(Request $request)
{
    $request->validate([
        'resolucion' => 'required|numeric',
        'gestion' => 'required|date',
        'dictamen' => 'required|numeric',
        'anio' => 'required',
        'periodo' => 'required',
        'fecha_reasig' => 'required|date',
        'documento' => 'required|file|mimes:pdf|max:2048',
        'carrera' => 'required',
    ]);

    $reasignacion = new Reasignacion();
    $reasignacion->resolucion = $request->resolucion;
    $reasignacion->gestion = $request->gestion;
    $reasignacion->dictamen = $request->dictamen;
    $reasignacion->anio = $request->anio;
    $reasignacion->periodo = $request->periodo;
    $reasignacion->fecha_reasig = $request->fecha_reasig;
    $reasignacion->id_programa = $request->carrera;

    if ($request->hasFile('documento')) {
        $file = $request->file('documento');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/reasignaciones', $filename);
        $reasignacion->documento = $filename;
    }

    $reasignacion->save();

    return redirect()->route('reasignaciones.index')
        ->with('success', 'Reasignación creada exitosamente.');
}

public function destroy($id)
{
    $reasignacion = Reasignacion::findOrFail($id);
    $reasignacion->delete();
    return redirect()->route('reasignaciones.index')
        ->with('success', 'La reasignación ha sido eliminada exitosamente.');
}

public function reasig($id) {
    $reasignacion = Reasignacion::findOrFail($id);
    
    $docentes = Docente::where('id_programa', $reasignacion->id_programa)
        ->whereHas('asignaciones', function ($query) use ($reasignacion) {
            $query->whereHas('designacion', function ($query) use ($reasignacion) {
                $query->where('anio', $reasignacion->anio)
                      ->where('periodo', $reasignacion->periodo);
            });
        })
        ->get();
    
    return view('reasignacion.reasig', compact('docentes', 'reasignacion'));
}

    public function asignarReasig($id) {
        return view('reasignacion.asignar', compact('id'));
    }


    public function materias($id_reasignacion, $id_docente) {
        $reasignacion = Reasignacion::find($id_reasignacion);
        $docente = Docente::find($id_docente);
        $materias = Materia::where('id_programa', $docente->id_programa)->get();
        //obtenemos materias de apoyo 
        $materiasApoyo = Apoyo::where('id_carrera', $reasignacion->id_programa)
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
    
        return view('reasignacion.asignar', compact('reasignacion', 'docente', 'materias', 'grupos'))->with('i');
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
public function pdf($id)
{
    $isReasignacion = false;
    $reasignacion = Reasignacion::findOrFail($id);
    $user = Auth::user();
    $fac = $user->roles->pluck('id_facultad')->first();
    $facultad = Facultad::where('id_facultad', $fac)->get();
    $docentes = Docente::select('docentes.*')
    
        ->distinct()
        ->join('asignaciones', 'docentes.id_docente', '=', 'asignaciones.id_docente')
        ->where('asignaciones.id_reasignacion', $id)
        ->get();
    $vicerrector = Facultad::where('id_facultad', '23')->get();
    $materias = Materia::whereHas('asignaciones', function ($query) use ($id) {
        $query->where('asignaciones.id_reasignacion', $id);
    })
        ->with(['asignaciones' => function ($query) use ($id) {
            $query->where('asignaciones.id_reasignacion', $id);
        }])
        ->get();

    $materias = $materias->map(function ($materia) use ($reasignacion) {
        $materia['es_apoyo'] = $materia->apoyo->contains('id_carrera', $reasignacion->id_programa);
        return $materia;
    });

    $pdf = PDF::loadView('designacion.pdf', [
        'isReasignacion' => $isReasignacion,
        'designacion' => $reasignacion,
        'docentes' => $docentes,
        'materias' => $materias,
        'facultad' => $facultad,
        'vicerrector' => $vicerrector,
        
    ]);
    return $pdf->stream();
}








}

<?php
namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\Materia;
use App\Models\Facultad;
use App\Models\Carrera;
use App\Models\Apoyo;
use App\Models\Designacion;
use App\Models\Asignacion;
use App\Models\Consultor;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\DB; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Policies\CarreraPolicy;
use Dompdf\Dompdf;
use PDF;

class DesignacionController extends Controller
{
    public function index()
{
    $user = Auth::user();
if ($user->hasRole('Vicerrectorado')) {
    $carreras = Carrera::pluck('programa', 'id_programa');
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
               ->pluck('programa', 'id_programa');
               
    $designaciones = Designacion::whereHas('carrera', function($query) use ($facultad_id) {
                $query->where('id_facultad', $facultad_id);
                })
                ->get();
    $anioActual = date('Y');
    $anio = range($anioActual, $anioActual+10);
}
return view('designacion.index', compact('carreras', 'designaciones', 'anio', 'anioActual'))->with('i');
}


public function store(Request $request)
{
    $validatedData = $request->validate([
        'resolucion' => 'nullable|numeric',
        'dictamen' => 'required|numeric',
        'periodo' => 'required',
        'anio' => 'required',
        'gestion' => 'required|date',
        'documento' => 'required|file|mimes:pdf|max:20480',
        'carrera' => 'required',
        'tipo' => 'required',
        'fecha_desig' => 'required',
        'convocatoria' => 'nullable',
    ], [
        'dictamen.required' => 'El dictamen es obligatorio',
        'documento.required' => 'La resolucion y dictamen escaneados',
        'fecha_desig' => 'A partir de que fecha',
        'gestion' => 'Fecha de la resolucion',
    ]);

    $designacion = new Designacion;
    $designacion->resolucion = $validatedData['resolucion'];
    $designacion->dictamen = $validatedData['dictamen'];
    $designacion->periodo = $validatedData['periodo'];
    $designacion->anio = $validatedData['anio'];
    $designacion->gestion = $validatedData['gestion'];
    $designacion->fecha_desig = $validatedData['fecha_desig'];
    $designacion->id_programa = $validatedData['carrera'];
    $designacion->tipo_docente = $validatedData['tipo'];
    $designacion->convocatoria = $validatedData['convocatoria'];

    if ($request->hasFile('documento')) {
        $file = $request->file('documento');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/designaciones', $filename);
        $designacion->documento = $filename;
    }

    if ($designacion->save()) {
        return response()->json(['success' => 'La designación ha sido creada exitosamente']);
    } else {
        return response()->json(['error' => 'Error al guardar la designación'], 500);
    }
}
public function destroy($id)
{
    $designacion = Designacion::findOrFail($id);
    $designacion->delete();
    return redirect()->route('designaciones.index')
        ->with('success', 'La designación ha sido eliminada exitosamente.');
}
    public function update (Request $request, $id) {
        $designacion = Designacion::find($id);
        $designacion->resolucion = $request->resolucion;
        $designacion->periodo = $request->periodo;
        $designacion->gestion = $request->gestion;
        $designacion->carrera_id = $request->carrera;
        $designacion->save();
        return redirect()->route('designacion.index')->with('success', 'La designación ha sido actualizada correctamente.');
        $designacion->dictamen = $request->dictamen;
    }
    public function edit($id_designacion)
{
    $designacion = Designacion::findOrFail($id_designacion);
    return view('designacion.index', compact('designacion', 'carreras', 'designaciones'))->with('i');
}

// ------------- funciones para asignar materias ------------------------------
    public function asignar($id){
        $designacion = Designacion::findOrFail($id);
        $docentes = Docente::where('id_programa', $designacion->id_programa)->where('estado','=', 'B')->get();
        $materias = Materia::where('id_programa', $designacion->id_programa)->get();
        return view('designacion.asignar', compact('designacion', 'docentes', 'materias'));
    }
    

public function buscar(Request $request) {
    $nombres = $request->input('nombres');
    $paterno = $request->input('paterno');
    $materno = $request->input('materno');
    $ci = $request->input('ci');

    $docentes = Docente::where(function($query) use ($nombres, $paterno, $materno, $ci) {
        if (!empty($nombres)) {
            $query->where('nombres', 'LIKE', '%' . $nombres . '%');
        }
        if (!empty($paterno)) {
            $query->where('paterno', 'LIKE', '%' . $paterno . '%');
        }
        if (!empty($materno)) {
            $query->where('materno', 'LIKE', '%' . $materno . '%');
        }
        if (!empty($ci)) {
            $query->where('ci', 'LIKE', '%' . $ci . '%');
        }
    })->get();

    return view('designacion.resultados', ['docentes' => $docentes]);
}

public function pdf($id)
{
    $isReasignacion = true; // Agrega esta línea para indicar que es una reasignación
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

    $pdf = PDF::loadView('reasignacion.pdf', [
        'isReasignacion' => $isReasignacion,
        'designacion' => $reasignacion, // Cambia 'designacion' a 'reasignacion'
        'docentes' => $docentes,
        'materias' => $materias,
        'facultad' => $facultad,
        'vicerrector' => $vicerrector
    ]);
    return $pdf->stream();
}


 
public function pdfExtr($id)
{
    $designacion = Designacion::find($id);

    $user = Auth::user();
    $fac = $user->roles->pluck('id_facultad')->first();
    $facultad = Facultad::where('id_facultad', $fac)->get();
    $docentes = Docente::select('docentes.*')
        ->distinct()
        ->join('asignaciones', 'docentes.id_docente', '=', 'asignaciones.id_docente')
        ->where('asignaciones.id_designacion', $id)
        ->get();
    $vicerrector = Facultad::where('id_facultad', '23')->get();
    $materias = Materia::whereHas('asignaciones', function($query) use ($id) {
        $query->where('asignaciones.id_designacion', $id);
    })
    ->with(['asignaciones' => function($query) use ($id) {
        $query->where('asignaciones.id_designacion', $id);
    }])
    ->get();

    // Obtener las materias de apoyo para el docente
    $materiasApoyo = Materia::whereHas('asignaciones', function($query) use ($id) {
        $query->where('asignaciones.id_designacion', $id)
            ->where('asignaciones.apoyo', true);
    })
    ->with(['asignaciones' => function($query) use ($id) {
        $query->where('asignaciones.id_designacion', $id)
            ->where('asignaciones.apoyo', true);
    }])
    ->get();

    $pdf = PDF::loadView('designacion.pdfExtr', [
        'designacion' => $designacion, 
        'materias' => $materias, 
        'materiasApoyo' => $materiasApoyo,
        'docentes' => $docentes, 
        'facultad' => $facultad, 
        'vicerrector' => $vicerrector
    ]);
    
    return $pdf->stream();
}

    public function consultor($id)
{
    $designacion = Designacion::findOrFail($id);
    $asignaciones = $designacion->asignaciones->groupBy('id_docente');
    $consultores = Consultor::where('id_designacion', $id)->get();
    return view('designacion.consultor', compact('designacion', 'asignaciones', 'consultores'));
}
    public function guardarConsultor(Request $request)
{
    $validatedData = $request->validate([
        'id_designacion' => 'required',
        'id_docente' => 'required',
        'contrato' => 'required|mimes:pdf|max:20480', 
    ]);
    $consultor = new Consultor();
    $consultor->id_designacion = $validatedData['id_designacion'];
    $consultor->id_docente = $validatedData['id_docente'];
        if ($request->hasFile('contrato')) {
            $file = $request->file('contrato');
            $filename = time() . '_' . $request->input('id_designacion') . '_' . $file->getClientOriginalName();
            $file->storeAs('public/designaciones/consultores', $filename);
            $consultor->contrato = $filename;
        }
        $consultor->save();
    return redirect()->back()->with('success', 'Consultor guardado correctamente');
}
public function actualizar(Request $request, $id)
{
    $consultor = Consultor::findOrFail($id);
    if ($request->hasFile('contrato')) {
        $contrato = $request->file('contrato');
        $contratoNombre = time() . '_' . $contrato->getClientOriginalName();
        $contrato->storeAs('public/designaciones/consultores', $contratoNombre);
        $consultor->contrato = $contratoNombre;
    }
    $consultor->save();
    return redirect()->back()->with('success', 'El contrato se ha actualizado correctamente.');
}






}

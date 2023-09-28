<?php

namespace App\Http\Controllers;
use App\Models\Apoyo;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Carrera;
use Illuminate\Http\Request; 


class ApoyoController extends Controller
{
    public function apoyoCarrera()  //vista principal apoyo 
{
    $carreras = Carrera::pluck('programa');
    return view('carrera.showApoyo', compact('carreras'));
}

public function apoyo($id)
{   
    $apoyo = Apoyo::all();
    return view('apoyo.index', compact('apoyo', 'id'))->with('i');
}
public function materiasApoyo(Request $request)
{
    $id_programa = $request->input('id_programa');
    $carrera = Carrera::where('id_programa', $id_programa)->first();
    $materiasApoyo = Apoyo::where('id_programa', $id_programa)->get();

    return view('apoyo.materias', compact('carrera', 'materiasApoyo'))->with('i');
}
public function store($carrera, $programa, $id_materia)
{
    $apoyo = Apoyo::where('id_programa', $programa)
                  ->where('id_materia', $id_materia)
                  ->first();
    
    if (!$apoyo) {
        return redirect()->back()->with('error', 'No se encontró el registro de apoyo.');
    }
    
    if ($apoyo->id_carrera === null) {
        $apoyo->id_carrera = $carrera;
        $apoyo->save();
        $carreraAsignada = Carrera::findOrFail($carrera)->programa;
        return redirect()->back()->with('swal_success', 'La materia se asignó como apoyo correctamente a otra carrera.')
                                  ->with('carreraAsignada', $carreraAsignada);
    }
    
    $carreraAsignada = Carrera::findOrFail($apoyo->id_carrera)->programa;
    return redirect()->back()->with('swal_info', 'La materia ya está asignada como apoyo a la carrera: '. $carreraAsignada);
}
public function eliminarApoyo($id_apoyo)
{
    $apoyo = Apoyo::where('id_materia', $id_apoyo)->firstOrFail();
    $apoyo->delete();

    // Redireccionar con mensaje de éxito
    return redirect()->back()->with('success', 'El apoyo se eliminó correctamente.');
}







public function publicar($id)   //publica las materias de apoyo
{
    $materia = Materia::findOrFail($id);
    $id_programa = $materia->id_programa;
    $existente = Apoyo::where('id_materia', $id)->where('id_programa', $id_programa)->exists();

    if ($existente) {
        return redirect()->back()->with('error', 'La materia ya está asignada como apoyo.')->with('swal', 'error');
    }
    Apoyo::create([
        'id_materia' => $id,
        'id_programa' => $id_programa,
    ]);

    return redirect()->back()->with('success', 'La materia se asignó como apoyo correctamente.')->with('swal', 'success');
}




}

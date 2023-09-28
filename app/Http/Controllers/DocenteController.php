<?php

namespace App\Http\Controllers;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Carrera;
use App\Models\Facultad;
use App\Models\Asignacion;
use Illuminate\Http\Request; //recupera datos de la vista, los datos que son enviados por POST o GET
use Illuminate\Support\Facades\DB; //nos permite trabajar con la base de datos utilizando procedimientos almacenados y otros
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class DocenteController extends Controller
{
   

   public function index()
{
    $docentes = Docente::all(); // Agregar el método get() para obtener los resultados de la consulta

    return view('docente.index', compact('docentes'))
        ->with('i');
}
    /*public function index(){
        $docentes = Docente::select('nombres', 'paterno', 'materno')->get();
        return datatables()->of($docentes)->toJson();
    }*/


    public function create($id)
{
    $docente = new Docente();
    $user = Auth::user();
    $fac = $user->roles->pluck('id_facultad')->first();
    $carreras = Carrera::where('id_facultad', $fac)
        ->where('id_programa', $id)
        ->pluck('programa', 'id_programa');
    $carrera = Carrera::find($id);
    return view('docente.create', compact('docente', 'carreras', 'fac', 'carrera'));
}


    //---------Controladores de Asignacion de Materias a Docentes
   /* public function asignacion($id){
        $docente = Docente::find($id);
        $materias = Materia::all();
        return view('docente.asignacion', compact('docente', 'materias'));
    }
    public function storeMaterias(Request $request){
        $docente = Docente::find(2);
        $docente->materias()->sync($request->input('materias', []));
        return redirect()->route('docente.index')->with('success', 'Materias asignadas correctamente');
    }*/
    //--------Fin de los controladores de Asignacion--------------
    public function store(Request $request)
    {
        
        $docente = Docente::create($request->all());
        return redirect()->route('carreras.showDocentes', $request->id_programa)
                 ->with('success', 'El Docente '.$request->nombres.' '.$request->paterno.' '.$request->materno.' ha sido creado Correctamente');
    }


    public function show(Docente $docente)
    {
        return view('docentes.show', compact('docente'));
    }

    public function edit($id)
    {
        $docente = Docente::find($id);
        $user = Auth::user();
        $fac = $user->roles->pluck('id_facultad')->first();
        $carreras = Carrera::all()->pluck('programa', 'id_programa');
        return view('docente.edit', compact('docente', 'carreras'));
    }

    public function update(Request $request, $id)
    {
        $docente = Docente::find($id);
        $docente->id_programa = $request->get('id_programa');
        $docente->nombres = $request->get('nombres');
        $docente->paterno = $request->get('paterno');
        $docente->materno = $request->get('materno');
        $docente->ci = $request->get('ci');
        $docente->abre_titulo = $request->get('abre_titulo');
        $docente->sexo = $request->get('sexo');
        $docente->tiempo = $request->get('tiempo');
        $docente->estado = $request->get('estado');
        $docente->tipo_docente = $request->get('tipo_docente');
        $docente->save();
        
        return redirect()->route('carreras.showDocentes', $docente->id_programa)
                 ->with('success', 'Los datos del docente '.$docente->nombres.' '.$docente->paterno.' '.$docente->materno.' han sido actualizados correctamente.');


        
    }

    public function destroy(Docente $docente)
    {
        
        $facultad = Facultad::where('id_docente', $docente->id_docente)->first();
        if ($facultad) {
            return redirect()->route('carreras.showDocentes', $docente->carreras->id_programa)->with('error', 'No se puede eliminar al docente porque es decano de la facultad de '.$facultad->facultad.'.');
        }
        $docente->delete();
    
        return redirect()->route('carreras.showDocentes', $docente->id_programa)
        ->with('error', 'El Docente '.$docente->nombres.' '.$docente->paterno.' '.$docente->materno.' ha sido Eliminado Correctamente');
    }
    
    
   
    

}

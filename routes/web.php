<?php
use Illuminate\Support\Facades\Route;
use App\Controller\DocenteController;
use App\Controller\AjaxController;
use App\Http\Controllers\DesignacionController;
use App\Http\Controllers\asignacionController;


Route::get('/', function () {
    return redirect('/login');
});

///desde aqui mis rutas 
Route::resource('docentes', 'App\Http\Controllers\DocenteController');
Route::get('docentes/create/{id}', 'App\Http\Controllers\DocenteController@create')->name('docentes.create');

Route::resource('materias', 'App\Http\Controllers\MateriaController');
Route::get('materias/create/{id}', 'App\Http\Controllers\MateriaController@create')->name('materias.create');


Route::resource('asignaciones', 'App\Http\Controllers\AsignacionController');
Route::resource('reasignaciones', 'App\Http\Controllers\ReasignacionController');
//Route::resource('designaciones', 'App\Http\Controllers\DesignacionController');
Route::resource('designaciones', 'App\Http\Controllers\DesignacionController')->parameters([
    'designaciones' => 'id_designacion'
]);

Route::resource('facultades', 'App\Http\Controllers\FacultadController');
Route::resource('carreras', 'App\Http\Controllers\CarreraController');
Route::resource('usuarios', 'App\Http\Controllers\UserController');
//aqui terminan mis rutas
//ruta datatables
//Route::get('docentes/json', 'App\Http\Controllers\AjaxController@docentesJson')->name('docentes.json');
Route::get('json', 'App\Http\Controllers\AjaxController@json')->name('json');
Route::post('json/view', 'App\Http\Controllers\AjaxController@view')->name('json.view');

//---------Rutas Ajax -------------
Route::get('docente/json', [App\Http\Controllers\AjaxController::class, 'json_docentes'])->name('docente.json');
Route::get('materia/json', [App\Http\Controllers\AjaxController::class, 'json_materias'])->name('materia.json');

//fin de ruta datatables
//-------------rutas de designaciones--------------------------------------asignarMaterias
Route::get('designaciones', 'App\Http\Controllers\DesignacionController@index')->name('designaciones.index');
Route::get('/designaciones/docentes', 'App\Http\Controllers\DesignacionController@docentes')->name('designaciones.docentes');
Route::post('/designaciones/buscar', 'App\Http\Controllers\DesignacionController@buscar')->name('designaciones.buscar');
Route::post('/designaciones/asignar/{id}', 'App\Http\Controllers\DesignacionController@asignar')->name('designaciones.asignar');
//Route::get('/designaciones/designacion/{id}', 'App\Http\Controllers\DesignacionController@edit')->name('designaciones.edit');
Route::get('/asignaciones/materias/{id}', 'App\Http\Controllers\AsignacionController@materias')->name('asignaciones.materias');

Route::post('/asignaciones', 'App\Http\Controllers\AsignacionController@store')->name('asignaciones.store');
Route::post('/asignaciones/materias', 'App\Http\Controllers\AsignacionController@storeReasig')->name('asignaciones.store.reasig');
Route::get('/asignaciones/show', 'App\Http\Controllers\AsignacionController@show')->name('asignaciones.show');
Route::post('/asignaciones/show/ver', 'App\Http\Controllers\AsignacionController@ver')->name('asignaciones.show.ver');
//Route::delete('asignaciones/{id}', 'App\Http\Controllers\AsignacionController@destroy')->name('asignaciones.destroy');
Route::delete('asignaciones/materias/{id}', 'App\Http\Controllers\AsignacionController@deleteMateria')->name('asignaciones.destroy');
Route::get('/asignaciones/materias/{id_reasignacion}/{id_docente}', 'App\Http\Controllers\ReasignacionController@materias')->name('reasignaciones.materias');


//Route::get('designaciones/show', 'App\Http\Controllers\DesignacionController@show')->name('designaciones.show');
//-----------------------rutas vistas carreras-----------------------------
Route::get('carreras/showDocentes/{id}', 'App\Http\Controllers\CarreraController@showDocentes')->name('carreras.showDocentes');
Route::get('carreras/showMaterias/{id}', 'App\Http\Controllers\CarreraController@showMaterias')->name('carreras.showMaterias');
Route::get('carreras/{id_programa}/apoyo',  'App\Http\Controllers\ApoyoController@publicar')->name('apoyo.carrera');
Route::get('carreras/materia/apoyo/{id}', 'App\Http\Controllers\ApoyoController@apoyo')->name('carreras.apoyo');
Route::post('carreras/materias-apoyo', 'App\Http\Controllers\ApoyoController@materiasApoyo')->name('carreras.materias-apoyo');
Route::get('/materias/showApoyo/materias', 'App\Http\Controllers\AjaxController@json_apoyo')->name('carreras.showApoyo.json');
Route::get('carreras/materia/apoyo/asignar/{carrera}/{programa}/{id_materia}', 'App\Http\Controllers\ApoyoController@store')->name('apoyo.guardar');
Route::delete('materias/apoyo/{id_materia}', 'App\Http\Controllers\ApoyoController@eliminarApoyo')->name('apoyo.eliminar');


//_---------------------RUTA PDF-----------------------------------------
Route::get('designaciones/pdf/{id}', 'App\Http\Controllers\DesignacionController@pdf')->name('designaciones.pdf');
Route::get('designaciones/pdfExtr/{id}', 'App\Http\Controllers\DesignacionController@pdfExtr')->name('designaciones.pdfExtr');
Route::get('/designaciones/consultor/{id}', 'App\Http\Controllers\DesignacionController@consultor')->name('designaciones.consultor');
Route::post('/designaciones/consultor/guardar', 'App\Http\Controllers\DesignacionController@guardarConsultor')->name('designaciones.consultor.guardar');
Route::put('/designaciones/consultor/actualizar/{id}', 'App\Http\Controllers\DesignacionController@actualizar')->name('designaciones.consultor.actualizar');


//----------------------fin de las rutas------------------------------------
Route::resource('reportes', 'App\Http\Controllers\ReporteController');
Route::post('/reporte/general', 'App\Http\Controllers\ReporteController@reporteGeneral')->name('reporte.general');
Route::get('reporte/general/pdf/{id_programa}/{periodo}/{gestion}', [App\Http\Controllers\ReporteController::class, 'pdfReporte'])->name('reporte.pdf');
Route::get('/proveidos', 'App\Http\Controllers\ReporteController@proveidoDesignacion')->name('proveido.designacion');
Route::post('/proveidos/vista', 'App\Http\Controllers\ReporteController@proveidoVista')->name('proveido.vista');
Route::get('/proveidos/pdf/{id}', 'App\Http\Controllers\ReporteController@proveidoPDF')->name('proveido.pdf');




//---------------------RUTAS HORARIOS-----------------------------------------
Route::resource('horarios', 'App\Http\Controllers\HorarioController');
Route::post('/horarios/show/ver', 'App\Http\Controllers\HorarioController@showVer')->name('horarios.show.ver');
Route::post('/guardar-horarios', 'App\Http\Controllers\HorarioController@guardar')->name('horarios.guardar');





//--------------------FIN ----------------------------------------------------
//--------------------REASIGNACION ----------------------------------------------------
Route::get('reasignaciones/reasig/{id}', 'App\Http\Controllers\ReasignacionController@reasig')->name('reasignaciones.reasig');
Route::get('reasignaciones/asignar/{id}', 'App\Http\Controllers\ReasignacionController@asignarReasig')->name('reasignaciones.asignar');

Route::delete('asignaciones/materias/{id}', 'App\Http\Controllers\ReasignacionController@deleteMateria')->name('asignaciones.destroy');
Route::delete('/reasignaciones/{id}', 'App\Http\Controllers\ReasignacionController@destroy')->name('reasignaciones.destroy');
Route::get('/reasignaciones/pdf/{id}', 'App\Http\Controllers\ReasignacionController@pdf')->name('reasignaciones.pdf');

//--------------------FIN ----------------------------------------------------

//--------------------Reportes ----------------------------------------------------

//------------Fin de reportes ---------------------------------
//------------rutas home---------------------------------
Route::get('/home', 'App\Http\Controllers\HomeController@contador')->name('home');
//------------fin rutas----------------------------------
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




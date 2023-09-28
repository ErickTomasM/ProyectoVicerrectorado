<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Role as SpatieRole;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all(); // Obtener todos los usuarios desde el modelo User

        return view('usuario.index', compact('usuarios')); // Retornar la vista 'users.index' con los usuarios en la variable 'users'
    }
   

    public function edit($id) {
        $usuario = User::find($id);
        $roles = Role::all();
       return view('usuario.edit', compact('usuario', 'roles'));
    }
    /*public function update(Request $request, $id)
{
    $role = Role::findOrFail($request->role);
    $faculta = $role->facultad;
    
    $user = User::findOrFail($id);
    $user->roles()->sync($request->roles);
    return redirect()->route('usuarios.index', $user)->with('info', 'Se asignaron correctamente los roles');
}*/
public function update(Request $request, User $usuario)
{
    $usuario->syncRoles($request->roles);
    return redirect()->route('usuarios.index')->with('info', 'Roles asignados correctamente.');
}
public function destroy(User $usuario)
{
    $usuario->delete();

    return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
}


}

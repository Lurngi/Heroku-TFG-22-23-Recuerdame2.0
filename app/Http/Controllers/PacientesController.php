<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class PacientesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role']);
        $this->middleware('isTerapeuta')->except('show');
        $this->middleware('esCuidadorDe')->only('show');
    }
    
    /**
     * Obtiene la lista completa de pacientes y se los devuelve a la vista de lista pacientes
     */

    public function index()
    {

        //Sacamos a todos los pacientes de la bd
        $idTerapeuta = Auth::id();
        $pacientes = User::find($idTerapeuta)->pacientes;
        //Redireccionamos a la vista devolviendo la lista de pacientes
        return view("pacientes.index", compact("pacientes"));

        
    }

    /**
     * Devuelve la vista de crear paciente
     */

    public function create()
    {
        return view("pacientes.create");
    }

    /**
     * Almacena un paciente en la base de datos y redireccionamos a la lista de pacientes
     */

    public function store(Request $request)
    {

        //Se valida la request
        $validate = $request->validate([

            "nombre" => "required",
            "apellidos" => "required",
            "genero" => "required",
            "lugar_nacimiento" => "required",
            "nacionalidad" => "required",
            "fecha_nacimiento" => "required",
            "tipo_residencia" => "required",
            "residencia_actual" => "required"

        ]);

        //Almacenamos al paciente en la bd
        $idTerapeuta = Auth::id();
        $user = User::find($idTerapeuta);

        Paciente::create([

            "nombre" => $request->nombre,
            "apellidos" => $request->apellidos,
            "genero" => $request->genero,
            "lugar_nacimiento" => $request->lugar_nacimiento,
            "nacionalidad" => $request->nacionalidad,
            "fecha_nacimiento" => $request->fecha_nacimiento,
            "tipo_residencia" => $request->tipo_residencia,
            "residencia_actual" => $request->residencia_actual

        ])->users()->save($user);

        //Redireccionamos a la vista de lista pacientes
        return redirect("/pacientes");
        
    }

    /**
     * Obtiene el paciente especificado y lo devuelve a la vista de mostrar paciente
     */

    public function show($id)
    {
        //Obtenemos al paciente
        $paciente = Paciente::findOrFail($id);
        $cuidador = User::find($paciente->cuidador_id);
       
        session()->put('paciente', $paciente->toArray()); 
        //Devolvemos al paciente a la vista de mostrar paciente
        return view("pacientes.show", compact("paciente","cuidador"));

    }

    /**
     * Obtiene al paciente a editar y lo devuelve a la vista de editar paciente
     */

    public function edit(int $id)
    {
        //Sacamos al paciente de la bd
        $paciente = Paciente::findOrFail($id);

        session()->put('paciente', $paciente->toArray());
        //Devolvemos al paciente a la vista de editar paciente
        return view("pacientes.edit", compact("paciente"));
    }

    /**
     * Actualiza al paciente especificado y redirecciona a la lista de pacientes
     */

    public function update(Request $request, int $id)
    {
        //Sacamos al paciente de la bd
        $paciente = Paciente::findOrFail($id);

        //Actualizamos masivamente los datos del paciente
        $paciente->update($request->all());
        session()->put('paciente', $paciente->toArray()); 

        //Redireccionamos a lista pacientes
        return redirect("/pacientes");
        
    }

    /**
     * Elimina al paciente especificado de la base de datos y redirecciona a la lista de pacientes
     */

    public function destroy($id)
    {
        //Sacamos al paciente y lo borramos
        Paciente::findOrFail($id)->delete();
        session()->forget('paciente');

        //Redireccionamos a lista pacientes
        return redirect("/pacientes");
        
    }

    public function addPacienteToTerapeuta(int $id) {
        $paciente = Paciente::findOrFail($id);
        $users = User::where("rol_id","=",1)->get();

        return view("pacientes.addPacienteToTerapeuta", compact("paciente", "users"));
    }
}

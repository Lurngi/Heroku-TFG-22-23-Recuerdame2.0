<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use App\Models\Paciente;
use App\Models\Sesion;
use App\Models\Recuerdo;
use App\Models\Estado;
use App\Models\Etiqueta;
use App\Models\Etapa;
use App\Models\Emocion;
use App\Models\Categoria;
use App\Models\Tiporelacion;
use App\Models\Personarelacionada;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CalendarioController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'asignarPaciente']);
    }

    public function showByPaciente(int $idPaciente)
    {
        //$actividades = Actividad::all()->sortBy("id");
        $user = Auth::user();
        $show = false;
        $paciente = Paciente::find($idPaciente);
        $sesion = new Sesion();
        $recuerdo = new Recuerdo();
        $persona = new Personarelacionada();
        $recuerdos = Recuerdo::where('paciente_id', $paciente->id)->get();
        $personas = Personarelacionada::where('paciente_id', $paciente->id)->get();
        $estados = Estado::all()->sortBy("id");
        $etiquetas = Etiqueta::all()->sortBy("id");
        $etapas = Etapa::all()->sortBy("id");
        $emociones = Emocion::all()->sortBy("id");
        $categorias = Categoria::all()->sortBy("id");
        $tipos = Tiporelacion::all()->sortBy("id");
        $mostrarFoto = false;
        return view('calendario.showByPaciente', compact("idPaciente","paciente", "user", "show", "sesion", "recuerdo", "estados", "etiquetas", "etapas", "emociones", "categorias", "tipos", "recuerdos", "personas", "persona", "mostrarFoto"));
    }

    public function store(Request $request)
    {
        //throw new \Exception("{$request->start}");
        /*$validate = $request->validate([
            "start" => "required",
            "title" => "required",
            "paciente_id" => "required",
            "color" => "required",
            "description" => "required"
        ]);
*/
        $actividad = Actividad::updateOrCreate(
            [
                "start" => $request->start,
                "title" => $request->title,
                "paciente_id" => $request->idPaciente,
                "color" => $request->color,
                "description" => $request->obs
            ]
        );

        return redirect("/pacientes/$actividad->paciente_id/calendario");
    }

    public function update(Request $request)
    {
        /*$actividad = Actividad::findOrFail($request->id);
        $actividad->update($request->all());
        //$actividad = Actividad::findOrFail($request->id);*/
        if ($request->finished === "" || $request->finished === null)
            //return "<h1>Nada</h1>";
            $actividad = Actividad::updateOrCreate(
                ["id" => $request->id],
                [
                    "start" => $request->start,
                    "title" => $request->title,
                    "paciente_id" => $request->idPaciente,
                    "color" => $request->color,
                    "description" => $request->obs
                ]
            );
        else
            //return "<h1>$request->finished</h1>";
            $actividad = Actividad::updateOrCreate(
                ["id" => $request->id],
                [
                    "start" => $request->start,
                    "title" => $request->title,
                    "paciente_id" => $request->idPaciente,
                    "color" => $request->color,
                    "description" => $request->obs,
                    "finished" => $request->finished
                ]
            );
        return redirect("/pacientes/$actividad->paciente_id/calendario");
    }

    public function updateSesion(Request $request)
    {
        $sesion = Sesion::updateOrCreate(
            ['id' => $request->idSesion],
            [
                'fecha' => $request->fecha,
                'etapa_id' => $request->etapa_id,
                'objetivo' => $request->objetivo,
                'descripcion' => $request->descripcion,
                'fecha_finalizada' => $request->fecha_finalizada,
                'paciente_id' => $request->paciente_id,
                'user_id' => $request->user_id,
                'respuesta' => $request->respuesta
            ]
        );
        if (!is_null($request->recuerdos))
            $sesion->recuerdos()->sync($request->recuerdos);
        return redirect("pacientes/{$sesion->paciente->id}/calendario");
    }

    public function show(int $idPaciente)
    {
        $tipoUsuario = Auth::user()->rol_id;
        $actividad = Actividad::where("paciente_id", "=", $idPaciente)->get();
        foreach ($actividad as $a) {
            $a->tipo = "a";
        }
        if ($tipoUsuario === 2)
            return response()->json($actividad);
        else {
            $sesion = Sesion::where("paciente_id", "=", $idPaciente)->get();
            foreach ($sesion as $s) {
                $s->tipo = "s";
                $s->start = $s->fecha;
                $s->title = "Sesión";
                $s->recuerdos = $s->recuerdos;
                foreach ($s->recuerdos as $r) {
                    $r->etapa = Etapa::findOrFail($r->etapa_id);
                    $r->etiqueta = Etiqueta::findOrFail($r->etiqueta_id);
                    $r->categoria = Categoria::findOrFail($r->categoria_id);
                    $r->estado = Estado::findOrFail($r->estado_id);
                }
            }
            $sesionYactividad = $actividad->concat($sesion);
            $sesionYactividad->all();

            //CREA UN FICHERO PRUEBAS.JSON EN PUBLIC PARA VER QUE JSON SE OBTIENE, pruebas********
            /*$filename = "PRUEBAS.json";
            $handle = fopen($filename, 'w+');
            fputs($handle, $sesionYactividad->toJson(JSON_PRETTY_PRINT));
            fclose($handle);
            $headers = array('Content-type' => 'application/json');
            return response()->download($filename, 'PRUEBAS.json', $headers);*/
            return response()->json($sesionYactividad);
        }
    }

    public function destroy(Request $request)
    {
        $actividad = Actividad::findOrFail($request->id);
        $paciente = $actividad->paciente_id;
        $actividad->delete();
        return redirect("/pacientes/$paciente/calendario");
    }

    public function destroySesion(Request $request)
    {
        $sesion = Sesion::findOrFail($request->idSesion);
        $paciente = $sesion->paciente_id;
        $sesion->delete();
        return redirect("/pacientes/$paciente/calendario");
        //return "<h1>$request</h1>";
    }

    public function registroSesion(Request $request)
    {
        // NOTA: el atributo recuerdos es un array con los ids de cada recuerdo
        $sesion = Sesion::updateOrCreate(
            ['id' => $request->idSesion],
            [
                'fecha' => $request->fecha,
                'etapa_id' => $request->etapa_id,
                'objetivo' => $request->objetivo,
                'descripcion' => $request->descripcion,
                'fecha_finalizada' => $request->fecha_finalizada,
                'paciente_id' => $request->paciente_id,
                'user_id' => $request->user_id,
                'respuesta' => $request->respuesta
            ]
        );
        if (!is_null($request->recuerdos))
            $sesion->recuerdos()->sync($request->recuerdos);
        return redirect("pacientes/{$sesion->paciente->id}/calendario");
        //return "<h1>$request</h1>";
    }
}

<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\RecuerdosController;
use App\Http\Controllers\SesionesController;
use App\Http\Controllers\MultimediasController;
use App\Http\Controllers\PersonasRelacionadasController;
use App\Http\Controllers\InformesSesionController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\CuidadoresController;

use Illuminate\Support\Facades\Route;
use App\Models\Paciente;
use App\Models\Actividad;
use App\Models\Evaluacion;
use App\Models\Estado;
use App\Models\Residencia;
use App\Models\Etapa;
use App\Models\TipoRelacion;
use App\Models\PersonaRelacionada;
use App\Models\Usuario;
use App\Models\Sesion;
use App\Models\Categoria;
use App\Models\Multimedia;
use App\Models\Etiqueta;
use App\Models\Emocion;
use App\Models\Recuerdo;
use App\Models\Rol;
use App\Models\User;
use App\Models\Estudio;
use App\Models\Situacion;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', function () {
    return redirect('/pacientes');
});

Route::resources([
    'recuerdo' => RecuerdosController::class,
    'sesiones' => SesionesController::class,
    'pacientes' => PacientesController::class,
    'multimedias' => MultimediasController::class,
    'personas' => PersonasRelacionadasController::class,
    'calendario' => CalendarioController::class,
    'informesSesion' => InformesSesionController::class,
    'evaluaciones' => EvaluacionController::class,
    'cuidadores' => CuidadoresController::class
]);

//Registro y login
Auth::routes();

//RUTAS CUSTOMIZADAS CUIDADOR
Route::get('/pacientes/{id}/cuidadores/crear', 'App\Http\Controllers\CuidadoresController@create');
Route::post('/registroCuidador','App\Http\Controllers\CuidadoresController@registroCuidador');
Route::post('/actualizarCuidador','App\Http\Controllers\CuidadoresController@update');
Route::get('/pacientes/{id}/cuidadores', 'App\Http\Controllers\CuidadoresController@showByPaciente');
Route::get('/pacientes/{id}/cuidadores/{idC}', 'App\Http\Controllers\CuidadoresController@show');
Route::get('/pacientes/{id}/cuidadores/{idC}/editar', 'App\Http\Controllers\CuidadoresController@edit');
Route::post('/repeatedCuidador', 'App\Http\Controllers\CuidadoresController@repeatedCuidador');


//RUTAS CUSTOMIZADAS SESION
Route::post('/guardarSesion', 'App\Http\Controllers\SesionesController@store');
Route::get('/pacientes/{id}/sesiones/crear', 'App\Http\Controllers\SesionesController@create');
Route::get('/pacientes/{id}/sesiones/{idS}', 'App\Http\Controllers\SesionesController@show');
Route::get('/pacientes/{id}/sesiones/{idS}/editar', 'App\Http\Controllers\SesionesController@showEditable');
Route::get('/pacientes/{id}/sesiones', 'App\Http\Controllers\SesionesController@showByPaciente');
Route::get('/sesion/showAll', 'App\Http\Controllers\SesionesController@showAll');
Route::post('/pacientes/{id}/sesiones/{idS}/update', 'App\Http\Controllers\SesionesController@store');
Route::post('/updateAndRecuerdoNuevo','App\Http\Controllers\SesionesController@updateAndRecuerdoNuevo');
Route::post('/updateAndSeleccionarRecuerdos','App\Http\Controllers\SesionesController@updateAndSeleccionarRecuerdos');

//RUTAS CUSTOMIZADAS PACIENTE
Route::get('/pacientes/{id}/asignarTerapeutas', 'App\Http\Controllers\PacientesController@addPacienteToTerapeuta');
Route::post('/asignacionTerapeutas','App\Http\Controllers\PacientesController@asignacionTerapeutas');
Route::post('/actualizarPaciente','App\Http\Controllers\PacientesController@update');
Route::post('/borrar_foto_paciente', 'App\Http\Controllers\PacientesController@removePhoto');

//RUTAS CUSTOMIZADAS RECUERDO
Route::get('/pacientes/{id}/recuerdos', 'App\Http\Controllers\RecuerdosController@showByPaciente');
Route::get('/pacientes/{id}/recuerdos/crear', 'App\Http\Controllers\RecuerdosController@create');
Route::get('/pacientes/{id}/recuerdos/{idR}', 'App\Http\Controllers\RecuerdosController@show');
Route::get('/pacientes/{id}/recuerdos/{idR}/editar', 'App\Http\Controllers\RecuerdosController@edit');
Route::delete('/eliminarRecuerdo/{id}', 'App\Http\Controllers\RecuerdosController@destroy');
Route::post('/storeRecuerdoNoView', 'App\Http\Controllers\RecuerdosController@storeNoView');

//RUTAS CUSTOMIZADAS PERSONA RELACIONADA
Route::get('/pacientes/{id}/personas', 'App\Http\Controllers\PersonasRelacionadasController@showByPaciente');
Route::get('/pacientes/{id}/crearPersona', 'App\Http\Controllers\PersonasRelacionadasController@create');
Route::post('/crearPersona', 'App\Http\Controllers\PersonasRelacionadasController@store');
Route::post('/borrarFoto', 'App\Http\Controllers\PersonasRelacionadasController@removePhoto');
Route::get('/pacientes/{id}/personas/{idP}', 'App\Http\Controllers\PersonasRelacionadasController@show');
Route::get('/pacientes/{id}/personas/{idP}/editar', 'App\Http\Controllers\PersonasRelacionadasController@edit');
Route::post('/editarPersona', 'App\Http\Controllers\PersonasRelacionadasController@update');
Route::post('/storePersonaNoView', 'App\Http\Controllers\PersonasRelacionadasController@storeNoView');

//RUTAS CUSTOMIZADAS CALENDARIO
Route::get('/pacientes/{id}/calendario', 'App\Http\Controllers\CalendarioController@showByPaciente');
Route::post('/eliminarActividad', 'App\Http\Controllers\CalendarioController@destroy');

Route::post('/modificarActividad', 'App\Http\Controllers\CalendarioController@update');
Route::post('/calendarioSesion', 'App\Http\Controllers\CalendarioController@registroSesion');

Route::post('/modificarSesion', 'App\Http\Controllers\CalendarioController@updateSesion');
Route::post('/eliminarSesion', 'App\Http\Controllers\CalendarioController@destroySesion');
//Route::get('/mostrarActividades/{id}', 'App\Http\Controllers\CalendarioController@show');

//RUTAS CUSTOMIZADAS INFORMES SESION
Route::get('/pacientes/{id}/informesSesion', 'App\Http\Controllers\InformesSesionController@showByPaciente');
Route::get('/pacientes/{id}/sesiones/{idS}/generarInforme', 'App\Http\Controllers\InformesSesionController@generarInforme');
Route::get('/pacientes/{id}/sesiones/{idS}/informe', 'App\Http\Controllers\PDFController@verInformeSesion');
Route::get('/pacientes/{id}/sesiones/{idS}/ver', 'App\Http\Controllers\InformesSesionController@show');
Route::post('/cerrarInformeSesion', 'App\Http\Controllers\InformesSesionController@store');
Route::post('/generarPDFInformeSesion', 'App\Http\Controllers\InformesSesionController@generarPDFInformeSesion');
Route::post('/getRecuerdo', 'App\Http\Controllers\RecuerdosController@getNoView');


//RUTAS CUSTOMIZADAS EVALUACION
Route::get('/pacientes/{id}/evaluaciones', 'App\Http\Controllers\EvaluacionController@showByPaciente');
Route::get('/pacientes/{id}/evaluaciones/generarInforme', 'App\Http\Controllers\EvaluacionController@generarInforme');
Route::get('/pacientes/{id}/evaluaciones/{idE}/informe', 'App\Http\Controllers\PDFController@verInformeEvaluacion');
Route::get('/pacientes/{id}/evaluaciones/{idE}/editar', 'App\Http\Controllers\EvaluacionController@showEditable');
Route::get('/pacientes/{id}/evaluaciones/{idE}/ver', 'App\Http\Controllers\EvaluacionController@show');
Route::post('/cerrarEvaluacion', 'App\Http\Controllers\EvaluacionController@store');
Route::post('/modificarEvaluacion', 'App\Http\Controllers\EvaluacionController@update');
Route::post('/generarPDFEvaluacion', 'App\Http\Controllers\EvaluacionController@generarPDFInformeEvaluacion');

//RUTAS CUSTOMIZADAS HISTORIAS DE VIDA
Route::get('/pacientes/{id}/historias/generarHistoria', 'App\Http\Controllers\HistoriaController@generarHistoria');
Route::get('/historias/generarLibro', 'App\Http\Controllers\HistoriaController@generarLibroHistoria');
Route::get('/generarPDFHistoria', 'App\Http\Controllers\PDFController@generarPDFHistoria');
   
Route::post('/storeTipoNoView', 'App\Http\Controllers\TipoRelacionController@storeNoView');


/*********************************************************
    CREA DATOS EN LA BASE DE DATOS
*********************************************************/
Route::post('/prueba', function () {
    DB::table("rols")->insert([
        ["nombre" => "Terapeuta"],
        ["nombre" => "Cuidador"]
    ]);

    DB::table("generos")->insert([
        ["nombre" => "Hombre"],
        ["nombre" => "Mujer"],
        ["nombre" => "Otro"],
    ]);

    DB::table("etapas")->insert([
        ["nombre" => "Infancia"],
        ["nombre" => "Adolescencia"],
        ["nombre" => "Adulto joven"],
        ["nombre" => "Adulto"],
        ["nombre" => "Adulto Mayor"]
    ]);

    DB::table("estados")->insert([
        ["nombre" => "Conservado"],
        ["nombre" => "En riesgo"],
        ["nombre" => "Perdido"]
    ]);

    DB::table("emocions")->insert([
        ["nombre" => "Alegría"],
        ["nombre" => "Nostalgia"],
        ["nombre" => "Ira"],
        ["nombre" => "Enfado"],
        ["nombre" => "Tristeza"]
    ]);
    
    DB::table("estudios")->insert([
        ["nombre" => "Educación infantil"],
        ["nombre" => "Educación primaria"],
        ["nombre" => "ESO"],
        ["nombre" => "Bachillerato"],
        ["nombre" => "Formación profesional"],
        ["nombre" => "Carrera universitaria"],
        ["nombre" => "Másteres o postgrados"],
        ["nombre" => "Doctorado"],
        ["nombre" => "Sin estudios"]
    ]);

    DB::table("etiquetas")->insert([
        ["nombre" => "Positivo"],
        ["nombre" => "Neutro"],
        ["nombre" => "Negativo"]
    ]);

    DB::table("categorias")->insert([
        ["nombre" => "Familia"],
        ["nombre" => "Amistad"],
        ["nombre" => "Hobbies"],
        ["nombre" => "Trabajo"],
        ["nombre" => "Política"],
        ["nombre" => "Estudios"],
        ["nombre" => "Otro"]
    ]);

    DB::table("situacions")->insert([
        ["nombre" => "Soltero/a"],
        ["nombre" => "Casado/a"],
        ["nombre" => "Unión de hecho"],
        ["nombre" => "Separado/a"],
        ["nombre" => "Divorciado/a"],
        ["nombre" => "Viudo/a"]
    ]);

    DB::table("residencias")->insert([
        ["nombre" => "Piso"],
        ["nombre" => "Casa"],
        ["nombre" => "Centro de día"],
        ["nombre" => "Vivienda unifamiliar"],
        ["nombre" => "Residencia para mayores"],
        ["nombre" => "Otros"]
    ]);

    DB::table("multimedias")->insert([
        ["nombre" => "multimedia 1", "fichero" => "/img/avatar_hombre.png"],
        ["nombre" => "multimedia 2", "fichero" => "/img/avatar_mujer.png"]
    ]);

    DB::table("tiporelacions")->insert([
        ["nombre" => "Padre / Madre"],
        ["nombre" => "Hermano / Hermana"],
        ["nombre" => "Hijo / Hija"],
        ["nombre" => "Primo / Prima"],
        ["nombre" => "Tío / Tía"],
        ["nombre" => "Amigo / Amiga"],
        ["nombre" => "Otro"]
    ]);
    
    DB::table("users")->insert([
        ['nombre' => "Manuel", 'apellidos' => "López Jordan", 'email' => "terapeuta@gmail.com", 
             'rol_id' => 1,'telefono'=>null,'localidad'=>null,'parentesco'=>null,  'password' => Hash::make("terapeuta")],
        ['nombre' => "Cuidador", 'apellidos' => "Alfredo", 'email' => "cuidador@gmail.com",
             'rol_id' => 2,'telefono' => "684847324", 'localidad' => "Argüelles",
             'parentesco' => "Primer grado",'password' => Hash::make("cuidador")],
        ['nombre' => "Cuidador", 'apellidos' => "Joya y de Borbón", 'email' => "cuidador2@gmail.com",
             'rol_id' => 2,'telefono' => "656789234", 'localidad' => "Nuevos ministerios",
             'parentesco' => "Segundo grado",'password' => Hash::make("cuidador2")],
        ['nombre' => "Sofía", 'apellidos' => "Méndez Alvaro", 'email' => "terapeuta2@gmail.com", 
             'rol_id' => 1,'telefono'=>null,'localidad'=>null,'parentesco'=>null, 'password' => Hash::make("terapeuta")]
    ]);

    DB::table("pacientes")->insert([
        ["nombre" => "María Concepción", "apellidos" => "Martinez-Almeida García", "genero_id" => 2,
            "lugar_nacimiento" => "Madrid", "nacionalidad" => "Española", "fecha_nacimiento" => Carbon::create(1950, 7, 30),
            "residencia_id" => 1, "residencia_custom" => null, "residencia_actual" => "C/Toledo 49, Ático 9E", "ocupacion" => "Confeccionista", 
            "situacion_id" => 1, "estudio_id" => 4, "fecha_inscripcion" => Carbon::create(2021, 7, 7)],
        ["nombre" => "Cristina", "apellidos" => "Montserrat Plaza", "genero_id" => 2,
            "lugar_nacimiento" => "Madrid", "nacionalidad" => "Española", "fecha_nacimiento" => Carbon::create(1969, 1, 21),
            "residencia_id" => 2, "residencia_custom" => null, "residencia_actual" => "P.º de la Castellana, 261, 28046 Madrid", "ocupacion" => "Enfermera", 
            "situacion_id" => 1, "estudio_id" => 4, "fecha_inscripcion" => Carbon::create(2019, 4, 7)]
    ]);

    DB::table("personarelacionadas")->insert([
        ["nombre" => "Ignacio", "apellidos" => "Martinez-Almeida García", "telefono" => "678765456", 
            "ocupacion" => "Desconocido", "email" => "igMar@gmail.com", "localidad" => "C/Toledo 49, Ático 9E",
            "contacto" => false, "observaciones" => "Ignacio es el hermano menor de Concepción. Actualmente viven juntos y pasan bastante tiempo juntos. Ignacio es enérgetico desde siempre y lleva cuidando de Concepción 15 años. ",
            "tiporelacion_id" => 2, "paciente_id" => 1 ],
        ["nombre" => "Pablo", "apellidos" => "Martinez Gonzalez", "telefono" => "600000000",
            "ocupacion" => "Estudiante", "email" => "pabMar@gmail.com", "localidad" => "C/Toledo 49, Ático 9E",
            "contacto" => false, "observaciones" => "Es el hijo de Concepción. Tiene 31 años y no tiene hijos. Le gustan los videojuegos y a Concepción le agrada verle jugar.",
            "tiporelacion_id" => 3, "paciente_id" => 1 ],
        ["nombre" => "Eros", "apellidos" => "Guerrero Sosa", "telefono" => "666666666", 
            "ocupacion" => "Informático", "email" => "erGuer@gmail.com", "localidad" => "C/Toledo 49, Ático 9D",
            "contacto" => false, "observaciones" => "Es el vecino de Concepción. Tiene 62 años y muchas mascotas. Concepción en ocasiones se queja del ruido, pero le gusta tomar el café en su casa acompañada de los animales.",
            "tiporelacion_id" => 6, "paciente_id" => 1 ],
        ["nombre" => "Adrián", "apellidos" => "Prieto Campo", "telefono" => "600000001",
            "ocupacion" => "Carpintero", "email" => "adrPri@gmail.com", "localidad" => "Leon o Madrid",
            "contacto" => false, "observaciones" => "Amigo de la infancia de Concepción. En ocasiones viene a visitarla, se ponen al día y discuten sobre temas políticos.",
            "tiporelacion_id" => 6, "paciente_id" => 1 ],
        ["nombre" => "Samuel", "apellidos" => "Rodríguez Romero", "telefono" => "687773283", 
            "ocupacion" => "Estudiante", "email" => "saRoRo@gmail.com", "localidad" => "P.º de la Castellana, 261, 28046 Madrid",
            "contacto" => false, "observaciones" => "Es el hijo de Cristina. Estudia cerca de casa y quiere ser matemático.",
            "tiporelacion_id" => 3, "paciente_id" => 2 ],
        ["nombre" => "Andrés", "apellidos" => "Alba Izar", "telefono" => "675000000",
            "ocupacion" => "Profesor", "email" => "adrPri@gmail.com", "localidad" => "Madrid",
            "contacto" => false, "observaciones" => "Profesor de autoescuela de su hijo y amigo de Cristina. Toman té todas las tardes.",
            "tiporelacion_id" => 6, "paciente_id" => 2 ]
    ]);

    DB::table("actividads")->insert([
        ["start" => Carbon::now(), "title" => "Primera terapia", "paciente_id" => 1,
            "description" => "Primera terapia de evaluación a la paciente María Concepción", "color" => "#20809d"],
        ["start" => Carbon::now(), "title" => "Primera terapia", "paciente_id" => 2,
            "description" => "Primera terapia de evaluación a la paciente Cristina", "color" => "#20809d"]
    ]);
                                
    DB::table("evaluacions")->insert([
        ["paciente_id"=> 1, "fecha" => Carbon::create(2022, 9, 30), "gds" => 2, "gds_fecha" => Carbon::create(2022, 9, 30),
            "mental" => 2, "mental_fecha" => Carbon::create(2022, 9, 30), "cdr"=> 2, "cdr_fecha" => Carbon::create(2022, 9, 30),
            "nombre_escala" => "escala custom", "escala" => 2, "fecha_escala" => Carbon::create(2022, 10, 30),
            "diagnostico" => "Empeora poco a poco.", "observaciones" => "Ninguna" ],
        ["paciente_id"=> 1, "fecha" => Carbon::create(2022, 10, 30), "gds" => 1, "gds_fecha" => Carbon::create(2022, 10, 30),
            "mental" => 1, "mental_fecha" => Carbon::create(2022, 10, 30), "cdr"=> 1, "cdr_fecha" => Carbon::create(2022, 10, 30),
            "nombre_escala" => "nombre cualquiera", "escala" => 1, "fecha_escala" => Carbon::create(2022, 10, 30),
            "diagnostico" => "Ha empeorado gravemente.", "observaciones" => "No reconoce a su familia" ],
        ["paciente_id"=> 2, "fecha" => Carbon::create(2022, 10, 30), "gds" => 5, "gds_fecha" => Carbon::create(2022, 10, 30),
            "mental" => 5, "mental_fecha" => Carbon::create(2022, 10, 30), "cdr"=> 5, "cdr_fecha" => Carbon::create(2022, 10, 30),
            "nombre_escala" => "escala custom", "escala" => 5, "fecha_escala" => Carbon::create(2022, 10, 30),
            "diagnostico" => "Se encuentra en las primeras etapas.", "observaciones" => null ]
    ]);


    DB::table("sesions")->insert([
        ["fecha" => Carbon::create(2022, 9, 17, 15, 30 ,0), "etapa_id" => 1, "objetivo" => "Trabajar los recuerdos en la etapa de la adolescencia con ayuda de imágenes y videos", 
            "descripcion" => "Etapa importante a nivel de emociones", "barreras"=> "Algunos recuerdos ya no conservados.", "facilitadores" => "El recuerdo con sus amigos", 
            "fecha_finalizada" => Carbon::create(2022, 9, 19, 14,0,0), "paciente_id" => 1, "user_id" => 1, 
            "respuesta" => "Gestiona las emociones correctamente.", "observaciones" => "ninguna observacion", "duracion" => "01:30"],
        ["fecha" => Carbon::create(2022, 9, 22, 10, 15 ,0), "etapa_id" => 2, "objetivo" => "Trabajar la tristeza que le da al recordar a su marido ",
            "descripcion" => "Al trabajar los recuerdos relacionados con su marido, genera una tristeza en el paciente que hay que controlar", "barreras"=> "Dificultad para hablar de su marido.", "facilitadores" => null, 
            "fecha_finalizada" => null, "paciente_id" => 1, "user_id" => 1, 
            "respuesta" => "Ninguna", "observaciones" => null, "duracion" => null],
        ["fecha" => Carbon::create(2022, 10, 31, 10,30,0), "etapa_id" => 2, "objetivo" => "Pruebas iniciales",
            "descripcion" => "Iniciaremos la terapia como un repaso general", "barreras"=> null, "facilitadores" => "Las fotografías ayudan.", 
            "fecha_finalizada" => null, "paciente_id" => 2, "user_id" => 4, 
            "respuesta" => null, "observaciones" => null, "duracion" => null],
        ]);

    
    DB::table("recuerdos")->insert([
        [ "fecha" => Carbon::create(2019, 9, 10), "nombre" => "Entrada en el grado",
            "descripcion" => "Inició su formación en costura y recuerda las técnicas que allí aprendió.",
            "localizacion" => "Facultad de Costura UCM", "etapa_id" => 3, "categoria_id" => 6,
            "emocion_id" => 3, "estado_id" => 1, "etiqueta_id" => 3, "puntuacion" => 2, "paciente_id" => 1, "apto"=>0 ],
        [ "fecha" => Carbon::create(2022, 10, 13), "nombre" => "Cena con amigos",
            "descripcion" => "Cenó en Taco Bell su hijo Pablo y el vecino Eros, entre otros. Recuerda las risas e historias que allí se contaron. También haber pasado algo de frío.",
            "localizacion" => "Taco Bell Moncloa", "etapa_id" => 3, "categoria_id" => 3, "emocion_id" => 2,
            "estado_id" => 1, "etiqueta_id" => 1, "puntuacion" => 10, "paciente_id" => 1 ,"apto"=>1],
        [ "fecha" => Carbon::create(2022, 10, 13), "nombre" => "Fiesta en La Sierra",
            "descripcion" => "Asistió a la casa de campo de unos amigos en la Sierra y la recuerda con sentimientos de felicidad y ternura. Cuenta historias del momento y destaca haber ganado dinero en un bingo casero.",
            "localizacion" => "Discoteca Recuer-Dame, La Sierra", "etapa_id" => 3, "categoria_id" => 7, "emocion_id" => 1,
            "estado_id" => 2, "etiqueta_id" => 2, "puntuacion" => 7, "paciente_id" => 2,"apto"=>1 ]
    ]);    
    
    DB::table("multimedia_sesion")->insertOrIgnore([
        ["multimedia_id" => 1, "sesion_id" => 1],
        ["multimedia_id" => 2, "sesion_id" => 1],
        ["multimedia_id" => 1, "sesion_id" => 2],
        ["multimedia_id" => 1, "sesion_id" => 3],
    ]);

    DB::table("personarelacionada_recuerdo")->insertOrIgnore([
        ["personarelacionada_id" => 1, "recuerdo_id" => 1],
        ["personarelacionada_id" => 2, "recuerdo_id" => 1],
        ["personarelacionada_id" => 1, "recuerdo_id" => 2],
        ["personarelacionada_id" => 2, "recuerdo_id" => 2],
        ["personarelacionada_id" => 3, "recuerdo_id" => 2],
        ["personarelacionada_id" => 4, "recuerdo_id" => 2],
        ["personarelacionada_id" => 2, "recuerdo_id" => 3],
        ["personarelacionada_id" => 3, "recuerdo_id" => 3],
        ["personarelacionada_id" => 4, "recuerdo_id" => 3]
    ]);

    DB::table("recuerdo_sesion")->insertOrIgnore([
        ["recuerdo_id" => 1, "sesion_id" => 1],
        ["recuerdo_id" => 2, "sesion_id" => 1],
        ["recuerdo_id" => 1, "sesion_id" => 2],
        ["recuerdo_id" => 2, "sesion_id" => 2],
        ["recuerdo_id" => 3, "sesion_id" => 3]
    ]);

    DB::table("multimedia_recuerdo")->insertOrIgnore([
        ["multimedia_id" => 1, "recuerdo_id" => 1],
        ["multimedia_id" => 2, "recuerdo_id" => 1],
        ["multimedia_id" => 1, "recuerdo_id" => 2],
        ["multimedia_id" => 2, "recuerdo_id" => 2],
        ["multimedia_id" => 1, "recuerdo_id" => 3]
    ]);

    DB::table("paciente_user")->insertOrIgnore([
        ["paciente_id" => 1, "user_id" => 1],
        ["paciente_id" => 1, "user_id" => 4],
        ["paciente_id" => 2, "user_id" => 4],
        ["paciente_id" => 1, "user_id" => 2],
        ["paciente_id" => 2, "user_id" => 3]
    ]);

    return "<h1> Se ha llenado la base de datos con éxito</h1>";
});

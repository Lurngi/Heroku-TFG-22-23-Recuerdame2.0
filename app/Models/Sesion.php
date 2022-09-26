<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sesion extends Model
{
    use HasFactory;

    protected $fillable = [
        "fecha",
        "etapa_id",
        "objetivo",
        "descripcion",
        "barreras",
        "facilitadores",
        "fecha_finalizada",
        "paciente_id",
        "usuario_id",
        "respuesta"
    ];

    public function etapa(){
        return $this->belongsTo(Etapa::class);
    }

    public function paciente(){
        return $this->belongsTo(Paciente::class);
    }

    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function multimedias(){
        return $this->belongsToMany(Multimedia::class);
    }

    public function recuerdos(){
        return $this->belongsToMany(Recuerdo::class);
    }
}
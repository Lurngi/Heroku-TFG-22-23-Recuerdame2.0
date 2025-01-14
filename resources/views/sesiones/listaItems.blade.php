<div class="d-flex justify-content-start mb-3">
    <input hidden id="idUser" name="user_id" value="{{$user->id}}" required @if($show) disabled @endif>
    <input hidden id="idPaciente" name="paciente_id" value="{{$paciente->id}}" required @if($show) disabled @endif>
    <input type="hidden" name="idSesion" id="idSesion" value="{{$sesion->id}}">
    <div class="col d-inline">
        <label for="fecha" class="form-label labelShow">Fecha: <span class="asterisco">*</span></label>
        <input max="4000-12-31T23:00:00.0" min="1800-01-01T01:00:00.00" type="datetime-local" style="width: fit-content;" class="form-control form-control-sm" id="fecha" name="fecha" value="{{$sesion->fecha}}" required @if($show) disabled @endif>
    </div>

    <div class="col d-inline align-items-center">
        <label for="etapa" class="form-label labelShow ">Etapa:<span class="asterisco">*</span></label>
        <select class="form-select form-select-sm " style="width: fit-content;" name="etapa_id" required @if($show) disabled @endif>
            @foreach($etapas as $etapa)
            <option value="{{$etapa->id}}" @if($sesion->etapa && $sesion->etapa->id == $etapa->id)
                selected="selected"
                @endif
                >{{$etapa->nombre}}</option>
            @endforeach
        </select>
    </div>

    <div class="col d-inline">
        <label for="terapeuta" class="form-label labelShow">Terapeuta:</label>
        <label for="terapeuta" class="form-label form-label-sm">{{$user->nombre}} {{$user->apellidos}}</label>
    </div>
</div>

<div class="mb-3">
    <label for="objetivo" class="form-label labelShow">Objetivo:<span class="asterisco">*</span></label>
    <textarea class="form-control form-control-sm" id="objetivo" name="objetivo" rows="3" required @if($show) disabled @endif>{{$sesion->objetivo}}</textarea>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label labelShow">Descripción:</label>
    <textarea class="form-control form-control-sm" id="descripcion" name="descripcion" rows="3" @if($show) disabled @endif>{{$sesion->descripcion}}</textarea>
</div>

<div class="row">
    <div class="pt-4 pb-2">
        <h5 class="text-muted">Recuerdos</h5>
        <hr class="lineaTitulo">
    </div>

    <div class="tabla">
        <div class="d-flex justify-content-between upper">
            @if(!$show)
                @include('layouts.tableSearcher')
                <div class="justify-content-end d-flex p-2">
                    <button type="button" id="crearRecuerdo" name="crearRecuerdo" class="btn btn-success me-2 showmodal" @if(!str_contains(url()->current(), 'sesion')) data-show-modal="recuerdosCreator" @else data-bs-toggle="modal" data-bs-target="#recuerdosCreator" @endif><i class="fa-solid fa-plus"></i></button>
                    <button type="button" class="btn btn-success showmodal" @if(!str_contains(url()->current(), 'sesion')) data-show-modal="recuerdosExistentes" @else data-bs-toggle="modal" data-bs-target="#recuerdosExistentes" @endif>Añadir existente</button>
                </div>
            @endif
        </div>
        <table id="tabla_recuerdos" class="table table-bordered table-striped table-responsive datatable">
            <caption>Listado de recuerdos</caption>
            <thead>
                <tr class="bg-primary">
                    <th scope="col">Nombre</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Etapa</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Etiqueta</th>
                    @if($show)
                    <th class="fit10" scope="col"></th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @foreach ($sesion->recuerdos as $recuerdo)
                <tr>
                    <td>{{$recuerdo->nombre}}</td>
                    <td>{{date("d/m/Y", strtotime($recuerdo->fecha))}}</td>
                    <td>
                        @if(isset($recuerdo->etapa)){{$recuerdo->etapa->nombre}}@endif
                    </td>
                    <td>
                        @if(isset($recuerdo->categoria)){{$recuerdo->categoria->nombre}}@endif   
                    </td>
                    <td>
                        @if(isset($recuerdo->estado)){{$recuerdo->estado->nombre}}@endif
                    </td>
                    <td>
                        @if(isset($recuerdo->etiqueta)){{$recuerdo->etiqueta->nombre}}@endif
                    </td>
                    @if($show)
                    <td class="tableActions">
                        
                    </td>
                    @endif
                    <input type="hidden" value="{{$recuerdo->id}}" name="recuerdos[]">
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="pt-4 pb-2">
    <h5 class="text-muted">Material</h5>
    <hr class="lineaTitulo">
</div>

@if(!$show)
<div class="row">
    <div class="col-12 justify-content-end d-flex p-2">
        <!-- TODO REDIRIGIR A SELECCION DE MULTIMEDIA -->
        <!-- <a href="#" class="btn btn-success">Añadir existente</button></a> -->
    </div>
</div>
@endif

@if($show)
<div id="showMultimedia" class="row pb-2">
    @foreach ($sesion->multimedias as $media)
        @include("layouts.multimedia")
    @endforeach
</div>
@endif
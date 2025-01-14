@extends('layouts.structure')

@section('content')
<div class="container-fluid">
    <div class="pt-4 pb-2">
        <h5 class="text-muted">Registro cuidador</h5>
        <hr class="lineaTitulo">
    </div>

    <form method="POST" action="/registroCuidador" id="formulario">
        {{csrf_field()}}
        @include('cuidadores.listaItems')
        <div class="col-12">
            <a href="/pacientes/{{$paciente->id}}/cuidadores"><button type="button" class="btn btn-primary">Cancelar</button></a>
            <button type="submit" value="Guardar" id="guardar" class="btn btn-outline-primary">Finalizar</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @include('layouts.scripts')
    <script>
        let id = document.getElementById("paciente").value;
        let id2 = document.getElementById("id").value;
        var ruta = "/pacientes/" + id + "/cuidadores/" + id2;
    </script>
    <script src="/js/cuidador.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
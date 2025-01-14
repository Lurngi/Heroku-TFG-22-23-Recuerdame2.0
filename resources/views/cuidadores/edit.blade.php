@extends('layouts.structure')

@section('content')
<div class="container-fluid">
    <div class="pt-4 pb-2">
        <h5 class="text-muted">Editar cuidador</h5>
        <hr class="lineaTitulo">
    </div>

    <form method="POST" action="/actualizarCuidador" id="formulario">
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
    <!-- <script src="/js/cuidador.js"></script> -->
    <script src="/js/validacion.js"></script>
@endpush
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
            <button type="submit" value="Guardar" id="guardar" class="btn btn-outline-primary">Guardar</button>
            <a href="paciente/{{$paciente->id}}/cuidadores/"><button type="button" class="btn btn-primary">Atrás</button></a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    @include('layouts.scripts')
    <script src="/js/validacion.js"></script>
@endpush
@extends('layouts.structure')

@section('content')
<div class="container-fluid">
    <div class="pt-4 pb-2">
        <h5 class="text-muted">Datos de la sesión</h5>
        <hr class="lineaTitulo">
    </div>
    
    <form class="dropzone p-0"  style="border:none !important; background-color: #00000000;" id="d" method="post" action="/guardarSesion"  >
            {{csrf_field()}}
            <div style="padding: 20px;">
                    @include('sesiones.listaItems')
                    <div style="border: 1px solid #868e96;" class="dz-default dz-message" id="dzp">
                        <div class="container" style="height: 10em;">
                            <h2 style="color: #868e96;">Arrastre sus archivos</h1>
                        </div>
                    </div>
                    <div class="dropzone-previews">


                    </div>
            </div>
    
        <div>
            <button type="submit" id="guardar" name="guardarSesion" value="Guardar" class="btn btn-outline-primary">Guardar</button>
            <a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary">Atrás</button></a>
        </div>
    </form>
</div>

@include('sesiones.modals')
@include('recuerdos.modals')

@endsection

@push('scripts')
    @include('layouts.scripts') 
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
    <script src="/js/table.js"></script>
    <script>
        let id = document.getElementById("paciente_id").value;
        var ruta = "/pacientes/" + id + "/sesiones"
    </script>
    <script src="/js/dropzone.js"></script>
@endpush
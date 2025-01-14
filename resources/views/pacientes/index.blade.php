@extends('layouts.structure')

@section('content')
<div class="container-fluid">
    <div class="pt-4 pb-2">
        <h5 class="text-muted">Listado de pacientes</h5>
        <hr class="lineaTitulo">
    </div>
    <div class ="tabla">
        <div class="d-flex justify-content-between upper">
            @include('layouts.tableSearcher')
            <div class="justify-content-end d-flex">
                @if (Auth::user()->rol_id == 1)
                <!--<a href="/pacientes/0/cuidadores/crear"><button type="button"  id="mybutton" class="btn btn-primary btn-registro mx-3">Registro cuidador</button></a>-->
                <a href="{{route('pacientes.create')}}"><button type="button"  class="btn  btn-success"><i class="fa-solid fa-plus"></i></button></a>
                @endif
            </div>
        </div>
        <table id="tabla" class="table table-striped table-bordered table-condensed table-responsive datatable">
            <caption>Listado de pacientes</caption>
            <thead>
                <tr class="bg-primary">
                    <th class="fit5" scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th class="fit5" scope="col">Género</th>
                    <th class="fit5" scope="col">Edad</th>
                    <th class="fit5" scope="col"></th>
                </tr>
            </thead>
            <!--<tbody>-->
            @foreach($pacientes as $paciente)
                <tr class="">
                    @if (Auth::user()->rol_id == 1)
                    <td><a href="/pacientes/{{$paciente->id}}/sesiones" class="link-primary"> {{$paciente->nombre}}</a></td>
                    @else
                    <td><a href="/pacientes/{{$paciente->id}}/calendario" class="link-primary"> {{$paciente->nombre}}</a></td>
                    @endif
                    <td>{{$paciente->apellidos}}</td>
                    <td>
                        {{$paciente->genero->nombre}}
                    </td>
                    <td>
                        {{Carbon\Carbon::parse($paciente['fecha_nacimiento'])->age}} 
                    </td>
                    <td class="tableActions">
                        <div class="d-inline">
                        
                            <a href="/pacientes/{{$paciente->id}}"><i class="fa-solid fa-eye text-black tableIcon"></i></a>
                            <a href="{{route('pacientes.edit',$paciente->id)}}"><i class="fa-solid fa-pencil text-primary tableIcon"></i></a>
                            <form method="post" action="{{ route('pacientes.destroy', $paciente->id) }}" style="display:inline!important;">
                                {{csrf_field()}}
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="confirm_delete" data-toggle="tooltip" style="background-color: Transparent; border: none;"><i class="fa-solid fa-trash-can text-danger tableIcon"></i></button>
                            </form>
                            <a href="/pacientes/{{$paciente->id}}/asignarTerapeutas"><i class="fa-solid fa-users-line text-success tableIcon"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach

        </table>
    </div>
</div>

@include('layouts.deletePopUp')

@endsection

@push('scripts')
    @include('layouts.scripts')
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>  
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/js/table.js"></script>
    <script src="/js/confirm.js"></script>
    @if (Session::has('created'))
        @php 
            Illuminate\Support\Facades\Session::forget('created');
        @endphp
        <script>
            var action = "Creado"
        </script>
        <script src="/js/successAlert.js"></script>
    @endif
@endpush
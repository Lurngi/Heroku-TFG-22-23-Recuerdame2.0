
<div id="showMultimedia" class="row pb-2">
    <div class="img-wrap text-center mx-auto">
        @if (isset($paciente->multimedia))
        <a href="#" class="visualizarImagen"><img src="{{$paciente->multimedia->fichero}}" class=" img-responsive-sm img-thumbnail" ></a>
        @else
        <a href="#" class="visualizarImagen"><img src="/img/avatar_hombre.png" class="img-responsive-sm img-thumbnail" ></a>
        @endif
    </div>
</div>

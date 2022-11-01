<!-- MODALES -->
<div class="modal fade" id="personasCreator" tabindex="-1" aria-labelledby="personasCreatorLabel" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="personasExistentesLabel">Crear: Personas relacionadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" id="personasCreatorForm">

                {{csrf_field()}}
                <input type="hidden" name="paciente_id" id="paciente_id" value="{{Session::get('paciente')['id']}}">



                <div class="row form-group justify-content-between">
                    <div class="row col-sm-12 col-md-6 col-lg-5">
                        <label for="nombre" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-6">Nombre<span class="asterisco">*</span></label>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <input type="text" name="nombre" class="form-control form-control-sm" id="nombre" required>

                        </div>
                    </div>
                    <div class="row col-sm-12 col-md-6 col-lg-7">
                        <label for="apellidos" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-4">Apellidos<span class="asterisco">*</span></label>
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <input type="text" name="apellidos" class="form-control form-control-sm" id="apellidos" required>
                        </div>
                    </div>
                </div>



                <div class="row form-group justify-content-between">
                    <div class="row col-sm-12 col-md-6 col-lg-5">
                        <label for="telefono" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-6">Teléfono<span class="asterisco">*</span></label>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <input type="text" name="telefono" class="form-control form-control-sm" id="telefono" required>

                        </div>
                    </div>
                    <div class="row col-sm-12 col-md-6 col-lg-7">
                        <label for="ocupacion" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-4">Ocupación<span class="asterisco">*</span></label>
                        <div class="col-sm-12 col-md-12 col-lg-8">
                            <input type="text" name="ocupacion" class="form-control form-control-sm" id="ocupacion" required>
                        </div>
                    </div>

                </div>

                <div class="row form-group justify-content-between">
                    <div class="row col-sm-12 col-md-6 col-lg-5">
                        <label for="email" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-6">Email<span class="asterisco">*</span></label>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <input type="text" name="email" class="form-control form-control-sm" id="email" required>

                        </div>
                    </div>
                </div>

                <div class="row form-group justify-content-between">
                    <div class="row col-sm-12 col-md-6 col-lg-5">
                        <label for="tipo" class="form-label col-form-label-sm col-sm-12 col-md-12 col-lg-6">Tipo relación</label>
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <select class="form-select form-select-sm" id="tiporelacion_id" name="tiporelacion_id" required>
                                <option></option>
                                @foreach ($tipos as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div> <!-- Modal body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" data-bs-dismiss="modal" onclick="CrearPersonas()">Guardar</button>
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="personasExistentes" tabindex="-1" aria-labelledby="personasExistentesLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personasExistentesLabel">Personas relacionadas existentes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered recuerdameTable">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Tipo de Relacion</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="tablaPersonasExistentes">
                        <?php $i = 1 ?>
                        @foreach ($prelacionadas as $persona)
                        <tr>
                            <th scope="row"><?php echo $i ?></th>
                            <td>{{$persona->nombre}}</td>
                            <td>{{$persona->apellidos}}</td>
                            <td>{{$persona->tiporelacion_id}}</td>
                            <td id="personasSeleccionadas" class="tableActions">
                                <input class="form-check-input" type="checkbox" value="{{$persona->id}}" name="checkPersonaExistente[]" id="checkPersonaExistente">
                            </td>
                        </tr>
                        <?php $i++ ?>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="return agregarPersonas(checkPersonaExistente);">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function CrearPersonas() {
        /*
        0 Token
        1 Paciente_id
        2 Nombre
        3 Apellidos
        4 Telefono
        5 Ocupaacion
        6 Email
        */

        const inputValues = document.querySelectorAll('#personasCreatorForm input')
        var rel = document.getElementById("tiporelacion_id");
        //console.log(rel.value);
        //console.log(rel.options[rel.selectedIndex].text);


        var fd = new FormData();
        fd.append('nombre', inputValues[2].value);
        fd.append('apellidos', inputValues[3].value);
        fd.append('telefono', inputValues[4].value);
        fd.append('ocupacion', inputValues[5].value);
        fd.append('email', inputValues[6].value);
        fd.append('tiporelacion_id', rel.value);
        fd.append('paciente_id', inputValues[1].value);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "post",
            url: '/storePersonaNoView',
            processData: false, // tell jQuery not to process the data
            contentType: false, // tell jQuery not to set contentType
            data: fd,
            success: function(data) {
                console.log("ID NUEVA PERSONA:" + data["id"]);
                document.getElementById("divPersonas").innerHTML +=
                    '<tr>' +
                    '<th scope="row">' + (document.getElementById("divPersonas").getElementsByTagName("tr").length + 1) + '</th>' +
                    '<td>' + data["nombre"] + '</td>' +
                    '<td>' + data["apellidos"] + '</td>' +
                    '<td>' + data["tiporelacion_id"] + '</td>' +
                    '<input type="hidden" value=' + data["id"]+ ' name="checkPersona[]">' +
                    '</tr>';
                reloadPersona(data);
            },
            error: function(data) {
                console.log('Error:', data);
            }
        });





    }

    function reloadPersona(p) {
        let selected = Array.from(document.getElementById("divPersonas").getElementsByTagName("input"), function(s){
            console.log(s.value)
            return s.value
        })


        document.getElementById("tablaPersonasExistentes").innerHTML += 
        '<tr>' +
            '<th scope="row">' + p.id + '</th>' +
            '<td>' + p.nombre + '</td>' +
            '<td>' + p.apellidos + '</td>' +
            '<td>' + p.tiporelacion_id + '</td>' +
                '<td id="personasSeleccionadas" class="tableActions">' +
                    '<input class="form-check-input" type="checkbox" value=' + p.id + ' name="checkPersonaExistente[]" id="checkPersonaExistente" checked>' +
                '</td>' +
        '</tr>';

        document.getElementById("tablaPersonasExistentes").getElementsByTagName("input").forEach(c => {
            if(selected.includes(c.value)){
                c.checked = true;
            }
        })
    }
</script>

<script type="text/javascript">

    function agregarPersonas(p) {
        //console.log(p);
        document.getElementById("divPersonas").innerHTML = "";
        let allPersonas = document.getElementById("tablaPersonasExistentes").getElementsByTagName("tr");
        let n = 1;

        //falla con solo una persona relacioanda.
        for (let i = 0; i < allPersonas.length; i++) {
            let per =  allPersonas[i].getElementsByTagName("td");
            per = {
                "id": allPersonas[i].getElementsByTagName("th")[0].textContent,
                "nombre": per[0].textContent,
                "apellidos":per[1].textContent,
                "tiporelacion_id":per[2].textContent,
                "checked": allPersonas[i].getElementsByTagName("input")[0].checked
            }

            if (per.checked) {
                document.getElementById("divPersonas").innerHTML += '<tr>' +
                    '<th scope="row">' + (n++) + '</th>' +
                    '<td>' +per.nombre+ '</td>' +
                    '<td>' +per.apellidos+ '</td>' +
                    '<td>' +per.tiporelacion_id+ '</td>' +
                    '<input type="hidden" value=' + per.id + ' name="checkPersona[]">' +
                    '</tr>';
            }
        }
    }
</script>


$("#crearRecuerdo").on("click", function(event){
    let form = $("#recuerdosCreatorForm");
    form.removeClass("was-validated")
    form[0].reset()
})

$("#modal_recuerdo_guardar").on("click", function(event){

    let form = $("#recuerdosCreatorForm")[0]

    if (!form.checkValidity()){
        event.preventDefault()
        event.stopPropagation()
    }
    else{
        crearRecuerdo()
    }
    form.classList.add('was-validated')
})


function crearRecuerdo() {

    
    const inputValues = document.querySelectorAll('#recuerdosCreatorForm input')
    const selectValues = document.querySelectorAll('#recuerdosCreatorForm select')
    const textValues = document.querySelectorAll('#recuerdosCreatorForm textarea')

    let allPersonas = document.getElementById("tablaPersonasExistentes").getElementsByTagName("tr");
    let ids = []


    for (let i = 0; i < allPersonas.length; i++) {
        let per = allPersonas[i].getElementsByTagName("td");
        console.log(per)
        let persona = {
            "id": per[0].textContent,
            "nombre": per[1].textContent,
            "apellidos": per[2].textContent,
            "tiporelacion_id": per[3].textContent,
            "checked": allPersonas[i].getElementsByTagName("input")[0].checked
        }   
        
        
        if (persona["checked"]){
            console.log(persona)
            ids.push(persona["id"]) 
        }
            

    }

    var fd = new FormData();
    
    fd.append('paciente_id', inputValues[1].value);
    fd.append('nombre', inputValues[2].value);
    fd.append('fecha', inputValues[3].value);
    fd.append('puntuacion', inputValues[4].value);

    fd.append('estado_id', selectValues[0].value);
    fd.append('etiqueta_id', selectValues[1].value);
    fd.append('etapa_id', selectValues[2].value);
    fd.append('emocion_id', selectValues[3].value);
    fd.append('categoria_id', selectValues[4].value);

    fd.append('descripcion', textValues[0].value);
    fd.append('localizacion', textValues[1].value);

    for (var i = 0; i < ids.length; i++) {
        fd.append('ids_personas[]', ids[i]);
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: "post",
        url: '/storeRecuerdoNoView',
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        data: fd,
        success: function(data) {
            reloadRecuerdos(data);
        },
        error: function(data) {
            console.log('Error:', data);
        }
    });

 
    $("#recuerdosCreator").modal("hide")
}

function agregarRecuerdosExistentes(r) {
    //console.log(r.length);
    document.getElementById("divRecuerdos").innerHTML = "";
    let allRecuerdos = document.getElementById("tablaRecuerdosExistentes").getElementsByTagName("tr");
    let n = 1;
    for (let i = 0; i < allRecuerdos.length; i++) {

        let rec = allRecuerdos[i].getElementsByTagName("td")
        let recuerdo  = {
            "id": rec[0].textContent,
            "nombre": rec[1].textContent,
            "fecha": rec[2].textContent,
            "etapa": rec[3].textContent,
            "categoria": rec[4].textContent,
            "estado": rec[5].textContent,
            "etiqueta": rec[6].textContent,
            "checked": allRecuerdos[i].getElementsByTagName("input")[0].checked,
        }

        if (recuerdo.checked) {
            document.getElementById("divRecuerdos").innerHTML += '<tr>' +
                '<td>' + recuerdo.nombre + '</td>' +
                '<td>' + recuerdo.fecha + '</td>' +
                '<td>' + recuerdo.etapa + '</td>' +
                '<td>' + recuerdo.categoria + '</td>' +
                '<td>' + recuerdo.estado + '</td>' +
                '<td>' + recuerdo.etiqueta + '</td>' +
                '<input type="hidden" value=' + recuerdo.id + ' name="recuerdos[]">' +
                '</tr>';

        }
    }
}

function reloadRecuerdos(r) {
    let selected = Array.from(document.getElementById("divRecuerdos").getElementsByTagName("input"), function(s) {
        console.log(s.value)
        return s.value
    })

    if (!r.categoria_id) {
        r.categoria = {};
        r.categoria.nombre = " ";
    }
    if (!r.estado_id) {
        r.estado = {};
        r.estado.nombre = " ";
    }
    if (!r.etiqueta_id) {
        r.etiqueta = {};
        r.etiqueta.nombre = " ";
    }

    document.getElementById("tablaRecuerdosExistentes").innerHTML +=
        '<tr>' +
            '<td>' + r.id + '</td>' +
            '<td>' + r.nombre + '</td>' +
            '<td>' + r.fecha + '</td>' +
            '<td>' + r.etapa.nombre + '</td>' +
            '<td>' + r.categoria.nombre + '</td>' +
            '<td>' + r.estado.nombre + '</td>' +
            '<td>' + r.etiqueta.nombre + '</td>' +
            '<td id="recuerdosSeleccionados" class="tableActions">' +
                '<input class="form-check-input" type="checkbox" value=' + r.id + ' name="checkRecuerdo[]" id="checkRecuerdo" checked>' +
            '</td>' +
        '</tr>';

    document.getElementById("tablaRecuerdosExistentes").getElementsByTagName("input").forEach(c => {
        if (selected.includes(c.value)) {
            c.checked = true;
        }
    })

    document.getElementById("divRecuerdos").innerHTML +=
        '<tr>' +
        '<td>' + r.nombre + '</td>' +
        '<td>' + r.fecha + '</td>' +
        '<td>' + r.etapa.nombre + '</td>' +
        '<td>' + r.categoria.nombre + '</td>' +
        '<td>' + r.estado.nombre + '</td>' +
        '<td>' + r.etiqueta.nombre + '</td>' +
        '<input type="hidden" value=' + r.id + ' name="recuerdos[]">' +
        '</tr>';
}
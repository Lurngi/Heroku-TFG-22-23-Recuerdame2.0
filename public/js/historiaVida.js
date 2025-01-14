//multiple seleccion con checkbox en generar Historia de vida
var expanded = false;
var expandedEtiqueta = false;
var expandedEtapa = false;
var expandedCat = false;

function expandir(expanded, checkboxes) {
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
    return expanded;
}

function showCheckboxes(ide) {

    if (ide == 'checkboxesEtiqueta') {
        expandedEtiqueta = expandir(expandedEtiqueta, document.getElementById("checkboxesEtiqueta"));

    } else if (ide == 'checkboxesCat') {
        expandedCat = expandir(expandedCat, document.getElementById("checkboxesCat"));
    } else {
        expandedEtapa = expandir(expandedEtapa, document.getElementById("checkboxes"));
    }

}

let array = [];
let arrayEt = [];
let arrayCat = [];
let arrayEtapa = [];

function anadirInfo(array, string) {
    const index = array.indexOf(string);
    if (index > -1) { // only splice array when item is found
        array.splice(index, 1); // 2nd parameter means remove one item only
    } else array.push(string);
    return array;
}

function onSelect(string, elementoSeleccionado) {
    var select = document.getElementById(elementoSeleccionado);

    if (select.getAttribute("id") == 'seleccionadoEtiqueta') {
        select.textContent = anadirInfo(arrayEt, string);

    } else if (select.getAttribute("id") == 'seleccionadoCat') {
        select.textContent = anadirInfo(arrayCat, string);
    } else {
        select.textContent = anadirInfo(arrayEtapa, string);
    }
}

function onCheck(elementoSeleccionado) {
    var select = document.getElementById(elementoSeleccionado);

    if (select.getAttribute("value") == 0) {
        select.setAttribute("value", 1);

    } else select.setAttribute("value", 0);
}
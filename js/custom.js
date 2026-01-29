let borrar;

window.addEventListener("DOMContentLoaded", () =>{

    const form = document.getElementById("formNuevaTarea");
    form.addEventListener("submit", async (event) =>{
        event.preventDefault();

        agregarTarea();
    });

    const filasPendientes = document.getElementsByClassName("filaPendiente");
    Array.from(filasPendientes).forEach((fila) => {
        const tarea_id = fila.getAttribute("att_id");
        agregarEventosBotones(tarea_id);
    });

    const btnTareasPendientes = document.getElementById("btnTareasPendientes");
    btnTareasPendientes.addEventListener("click", () => {
        ponerTablaPendientes();
    });

    const btnTareasCompletadas = document.getElementById("btnTareasCompletadas");
    btnTareasCompletadas.addEventListener("click", () => {
        ponerTablaCompletadas();
    });
})

async function agregarTarea(){
    const form = document.getElementById("formNuevaTarea");
    const formData = new FormData(form);

    const checks = document.getElementsByClassName("form-check-input");
    Array.from(checks).forEach((check) => {
        if(check.checked){
            const id = parseInt(check.getAttribute("att_id"))
            formData.append(`categorias[${id}]`, 1);
        }
    });

    const url = "php/controlers/tareas/addTarea.php";

    const respuesta = await envioDDBB(formData, url);
    if(respuesta.success){
        escribirMensaje(respuesta);

        form.reset();

        const tabla = document.getElementById("tablaTareasPendientes").getElementsByTagName('tbody')[0];
        crearFilaNueva(tabla, respuesta.datos);
    }
    else{
        escribirMensaje(respuesta);
    }
}

async function envioDDBB(formData, url){
    return fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        return response.json();
    })
    .then(data => {
        return data;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

async function envioDDBBPruebas(formData, url){
    return fetch(url, {
        method: "POST",
        body: formData
    })
    .then(response => {
        return response.text();
    })
    .then(data => {
        console.log(data)
        return data;
    })
    .catch(error => {
        console.error("Error:", error);
    });
}


function crearFilaNueva(tabla, datos){    
    const categorias = categoriasFilaNueva(datos.categorias);

    const html = `
    <tr id="fila${datos.id}" att_id="${datos.id}">
        <td class="text-center">${datos.nombre}</td>
        <td class="text-center">${categorias}</td>
        <td class="text-center">
            <button class="btn btn-sm btn-danger" id = "eliminar${datos.id}" att_id="${datos.id}">Eliminar</button>
            <button class="btn btn-sm btn-success" id = "completar${datos.id}" att_id="${datos.id}">Completar</button>
        </td>
    </tr>
    `;
    tabla.innerHTML += html;

    agregarEventosBotones(datos.id);
}

function categoriasFilaNueva(categorias){
    let html = "";
    categorias.forEach(categoria => {
        html += `<span class="badge ${categoria.nombre} me-1">${categoria.nombre}</span>`;
    });
    return html;
}


function agregarEventosBotones(tarea_id){
    const botonEliminar = document.getElementById(`eliminar${tarea_id}`);

    const botonCompletar = document.getElementById(`completar${tarea_id}`);

    if(botonEliminar){
        botonEliminar.addEventListener("click", async () => {
            eliminarTarea(parseInt(botonEliminar.getAttribute("att_id")))
        });
    }
    
    if(botonCompletar){
        botonCompletar.addEventListener("click", async () => {
            completarTarea(parseInt(botonCompletar.getAttribute("att_id")))
        });
    }
}


async function eliminarTarea(tarea_id){
    const datos = new FormData();
    datos.append("tarea_id", tarea_id);

    const url = "php/controlers/tareas/deleteTarea.php";

    const respuesta = await envioDDBB(datos, url);
    if(respuesta.success){
        eliminarFila(tarea_id);
        escribirMensaje(respuesta);
    }
    else{
        escribirMensaje(respuesta);
    }
}

async function completarTarea(tarea_id){
    console.log("Hola")
    const datos = new FormData();
    datos.append("tarea_id", tarea_id);

    const url = "php/controlers/tareas/completTarea.php";

    const respuesta = await envioDDBB(datos, url);
    console.log(respuesta);
    if(respuesta.success){
        cambiarFilaATablaCompletadas(tarea_id, respuesta.datos);
    }
    else{
        escribirMensaje(respuesta.mensaje);

    }
}

function eliminarFila(tarea_id){
    console.log(tarea_id);
    const fila = document.getElementById(`fila${tarea_id}`);
    console.log(fila);
    fila.remove();
}

function escribirMensaje(respuesta){
    const mensajeHtml = document.getElementById("mensajeForm")

    const clase = respuesta.success ? "text-success" : "text-danger";

    mensajeHtml.innerText = respuesta.mensaje;
    mensajeHtml.classList.add(clase);
    borrar = setTimeout(() => {
        mensajeHtml.innerText = "";
        mensajeHtml.classList.remove(clase);
    }, 6000);
}


function ponerTablaPendientes(){
    document.getElementById("seccionPendientes").classList.remove("d-none");
    document.getElementById("seccionCompletadas").classList.add("d-none");
}

function ponerTablaCompletadas(){
    document.getElementById("seccionCompletadas").classList.remove("d-none");
    document.getElementById("seccionPendientes").classList.add("d-none");
}


function cambiarFilaATablaCompletadas(tarea_id, datos){
    eliminarFila(tarea_id);
    crearFilaCompletados(datos);
}

function crearFilaCompletados(datos){
    const tabla = document.getElementById("tablaTareasCompletadas").getElementsByTagName('tbody')[0];

    const categorias = categoriasFilaNueva(datos.categorias);

    const html = `
    <tr id="fila${datos.id}" att_id="${datos.id}">
        <td class="text-center">${datos.nombre}</td>
        <td class="text-center">${categorias}</td>
        <td class="text-center">
            <button class="btn btn-sm btn-danger" id = "eliminar${datos.id}" att_id="${datos.id}">Eliminar</button>
        </td>
    </tr>
    `;
    tabla.innerHTML += html;

    agregarEventosBotones(datos.id);
}
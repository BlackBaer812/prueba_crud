let borrar;

window.addEventListener("DOMContentLoaded", () =>{

    const form = document.getElementById("formNuevaTarea");
    form.addEventListener("submit", async (event) =>{
        event.preventDefault();

        agregarTarea();
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

    const mensajeHtml = document.getElementById("mensajeForm")

    const respuesta = await envioDDBBPruebas(formData, url);
    console.log(respuesta)
    if(respuesta.success){

    }
    else{
        mensajeHtml.innerText = respuesta.mensaje;
        mensajeHtml.classList.add("text-danger");
        borrar = setTimeout(() => {
            mensajeHtml.innerText = "";
            mensajeHtml.classList.remove("text-danger");
        }, 6000);
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
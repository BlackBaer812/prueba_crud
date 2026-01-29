<?php

require_once "php/controlers/tareas/tareas.php";

$tareasPen = tareasController::getTareasTodasPendientesCarga();
$tareasCom = tareasController::getTareasTodasCompletadasCarga();

$tareasPendientes = [];

foreach($tareasPen as $tarea){
    if(!isset($tareasPendientes[$tarea["id"]])){
        $tareasPendientes[$tarea["id"]] = [
            "id" => $tarea["id"],
            "nombre" => $tarea["nombre"],
            "categorias" => []
        ];
    }
    $tareasPendientes[$tarea["id"]]["categorias"][] = [
        "categoria_id" => $tarea["categoria_id"],
        "categoria_nombre" => $tarea["categoria_nombre"]
    ];
}

$tareasCompletadas = [];
foreach($tareasCom as $tarea){
    if(!isset($tareasCompletadas[$tarea["id"]])){
        $tareasCompletadas[$tarea["id"]] = [
            "id" => $tarea["id"],
            "nombre" => $tarea["nombre"],
            "categorias" => []
        ];
    }
    $tareasCompletadas[$tarea["id"]]["categorias"][] = [
        "categoria_id" => $tarea["categoria_id"],
        "categoria_nombre" => $tarea["categoria_nombre"]
    ];
}

?>
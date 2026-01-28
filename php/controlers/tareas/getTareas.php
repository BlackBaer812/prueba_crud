<?php

require_once "php/controlers/tareas/tareas.php";

$tareas = tareasController::getTareasTodasPendientesCarga();

$tareasPendientes = [];

foreach($tareas as $tarea){
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


?>
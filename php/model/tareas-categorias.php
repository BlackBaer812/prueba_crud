<?php

require_once __DIR__ . '/../common.php';

class TareasCategoriasModel extends commonFunctions{
    public static function addTareaCategoria($tarea_id, $categoria_id){
        $sql = "INSERT INTO tarea_categoria (tarea_id, categoria_id) VALUES (?, ?)";
        $datos = [$tarea_id, $categoria_id];
        return self::database($sql, $datos);
    }
}

?>
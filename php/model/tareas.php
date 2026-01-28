<?php

require_once __DIR__ . '/../common.php';

class tareasModel extends commonFunctions{
    public static function getTareasTodasPendientes(){
        $sql = "SELECT 
        tarea.id,
        tarea.nombre,
        categoria.id AS categoria_id,
        categoria.nombre AS categoria_nombre
        FROM tarea
        INNER JOIN tarea_categoria ON tarea.id = tarea_categoria.tarea_id
        INNER JOIN categoria ON tarea_categoria.categoria_id = categoria.id 
        WHERE finalizada = 0";
        $datos = [];
        return self::database($sql, $datos);
    }

    public static function getTareasTodasCompletadas(){
        $sql = "SELECT 
        tarea.id,
        tarea.nombre,
        categoria.id AS categoria_id,
        categoria.nombre AS categoria_nombre 
        FROM tarea
        INNER JOIN tarea_categoria ON tarea.id = tarea_categoria.tarea_id
        INNER JOIN categoria ON tarea_categoria.categoria_id = categoria.id 
        WHERE finalizada = 1";
        $datos = [];
        return self::database($sql, $datos);
    }

    public static function addTarea($nombre){
        $sql = "INSERT INTO tarea (nombre) VALUES (?)";
        $datos = [$nombre];
        return self::database($sql, $datos);
    }

    public static function getLastTareaID($nombre){
        $sql = "SELECT id FROM tarea WHERE nombre = ? ORDER BY id DESC LIMIT 1";
        $datos = [$nombre];
        return self::database($sql, $datos);
    }

    public static function getTarea($id){
        $sql = "SELECT 
            tarea.id,
            tarea.nombre,
            categoria.id AS categoria_id,
            categoria.nombre AS categoria_nombre 
        FROM tarea
        INNER JOIN tarea_categoria ON tarea.id = tarea_categoria.tarea_id
        INNER JOIN categoria ON tarea_categoria.categoria_id = categoria.id 
        WHERE tarea.id = ?";
        $datos = [$id];
        return self::database($sql, $datos);
    }

    public static function deleteTarea($id){
        $sql = "DELETE FROM tarea WHERE id = ?";
        $datos = [$id];
        return self::database($sql, $datos);
    }
}

?>
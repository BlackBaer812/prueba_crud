<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/crud/php/model/tareas.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/crud/php/model/tareas-categorias.php';

class tareasController{
    /*GET Tareas pendientes */
    public static function getTareasTodasPendientesCarga(){
        return self::getTareasTodasPendientesHandeler();
    }

    private static function getTareasTodasPendientesHandeler(){
        return tareasModel::getTareasTodasPendientes();
    }

    /*GET Tareas completadas */
    public static function getTareasTodasCompletadasCarga(){
        return self::getTareasTodasCompletadasHandeler();
    }

    private static function getTareasTodasCompletadasHandeler(){
        return tareasModel::getTareasTodasCompletadas();
    }

    /*ADD Tarea */
    public static function addTareaVuelta(){
        return self::addTareaHandeler();
    }

    private static function addTareaHandeler(){
        $success = false;
        $mensaje = "";
        $error = "";
        $datos = [];

        $datos = $_POST;

        if($_POST["nombre"] != "" && isset($_POST["categorias"])){
            $response = tareasModel::addTarea($_POST["nombre"]);
            if(!isset($response["errorinfo"])){
                $lastID = tareasModel::getLastTareaID($_POST["nombre"]);
                
                if(!isset($lastID["errorinfo"])){
                    $tarea_id = $lastID[0]["id"];
                    $errores = [];
                    foreach($_POST["categorias"] as $categoria_id => $existe){
                        $responseCategoria = TareasCategoriasModel::addTareaCategoria($tarea_id, $categoria_id);
                        if(isset($responseCategoria["errorinfo"])){
                            $error = $responseCategoria["errorinfo"];
                            $errores[] = $error;
                        }
                    }

                    if(count($errores) == 0){
                        return self::datosGuardados($tarea_id);
                    }
                    else{
                        $mensaje = "Tarea agregada, pero hubo errores al asignar categorias.";
                        $error = $errores;   
                    }
                }
                else{
                    $mensaje = "Fallo al obtener el ID de la tarea.";
                    $error = $lastID["errorinfo"];
                }
                
            }
            else{
                $mensaje = "Fallo al agregar la tarea.";
                $error = $response["errorinfo"];
            }
        }
        else{
            $mensaje = "Faltan datos obligatorios.";
            $error = "";
        }

        return [
            "success" => $success,
            "mensaje" => $mensaje,
            "error" => $error,
            "datos" => $datos
        ];
    }

    /*DELETE Tarea */
    public static function deleteTareaVuelta(){
        return self::deleteTareaHandeler();
    }

    private static function deleteTareaHandeler(){
        $success = false;
        $mensaje = "";
        $error = "";
        $datos = [];

        $eliminado = tareasModel::deleteTarea($_POST["tarea_id"]);

        if(!isset($eliminado["errorinfo"])){
            $mensaje = "Tarea eliminada correctamente.";
            $success = true;
            $datos = ["id" => $_POST["tarea_id"]];
        }
        else{
            $mensaje = "Fallo al eliminar la tarea.";
            $error = $eliminado["errorinfo"];
        }

        return [
            "success" => $success,
            "mensaje" => $mensaje,
            "error" => $error,
            "datos" => $datos
        ];
    }

    /* COMPLETE Tarea */
    public static function completeTareaVuelta(){
        return self::completeTareaHandeler();
    }

    private static function completeTareaHandeler(){
        $success = false;
        $mensaje = "";
        $error = "";
        $datos = [];

        $completado = tareasModel::completeTarea($_POST["tarea_id"]);

        if(!isset($completado["errorinfo"])){
            return self::datosGuardados($_POST["tarea_id"]);
        }
        else{
            $mensaje = "Fallo al completar la tarea.";
            $error = $completado["errorinfo"];
        }

        return [
            "success" => $success,
            "mensaje" => $mensaje,
            "error" => $error,
            "datos" => $datos
        ];
    }


    private static function datosGuardados($tarea_id){
        $success = false;
        $mensaje = "";
        $error = "";
        $datos = [];

        $tareas = tareasModel::getTarea($tarea_id);
        if(!isset($tareas["errorinfo"])){
            foreach($tareas as $tarea){
                if(!isset($datos["id"])){
                    $datos["id"] = $tarea["id"];
                    $datos["nombre"] = $tarea["nombre"];
                    $datos["categorias"] = [];
                }
                $datos["categorias"][] = [
                    "id" => $tarea["categoria_id"],
                    "nombre" => $tarea["categoria_nombre"]
                ];
            }
            $mensaje = "Tarea agregada correctamente.";
            $success = true;
        }
        else{
            $mensaje = "Tarea agregada, pero hubo errores al obtener los datos.";
            $error = $tareas["errorinfo"];
        }

        return [
            "success" => $success,
            "mensaje" => $mensaje,
            "error" => $error,
            "datos" => $datos
        ];
    }

}

?>
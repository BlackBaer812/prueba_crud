<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/crud/php/model/tareas.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/crud/php/model/tareas-categorias.php';

class tareasController{
    public static function getTareasTodasPendientesCarga(){
        return self::getTareasTodasPendientesHandeler();
    }

    private static function getTareasTodasPendientesHandeler(){
        return tareasModel::getTareasTodasPendientes();
    }

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
                    foreach($_POST["categorias"] as $categoria_id => $existe){
                        $responseCategoria = TareasCategoriasModel::addTareaCategoria($tarea_id, $categoria_id);
                        if(isset($responseCategoria["errorinfo"])){
                            $mensaje = "Fallo al agregar la categoría a la tarea.";
                            $error = $responseCategoria["errorinfo"];
                            return [
                                "success" => $success,
                                "mensaje" => $mensaje,
                                "error" => $error,
                                "datos" => $datos
                            ];
                        }
                    }
                    $success = true;
                    $mensaje = "Tarea agregada correctamente.";
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

        // if(isset($_POST['nombre']) && !empty($_POST['nombre'])){
        //     $nombre = htmlspecialchars($_POST['nombre']);

        //     $sql = "INSERT INTO tarea (nombre, finalizada) VALUES ('$nombre', 0)";
        //     $result = tareasModel::databaseAction($sql);

        //     if($result){
        //         $success = true;
        //         $mensaje = "Tarea agregada correctamente.";
        //     } else {
        //         $error = "Error al agregar la tarea.";
        //     }
        // } else {
        //     $error = "El nombre de la tarea es obligatorio.";
        // }

        return [
            "success" => $success,
            "mensaje" => $mensaje,
            "error" => $error,
            "datos" => $datos
        ];
    }
}

?>
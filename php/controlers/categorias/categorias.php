<?php

require_once 'php/model/categorias.php';

class categoriasController{

    public static function getTodasCategoriasVuelta(){
        echo json_encode(self::getTodasCategoriasHandeler());
    }

    
    public static function getTodasCategoriasCarga(){
        return self::getTodasCategoriasHandeler();
    }

    /**
     * Maneja la obtención de todas las categorías.
     * @return array Las categorías obtenidas de la base de datos.
     */
    private static function getTodasCategoriasHandeler(){
        return categoriasModel::getTodasCategorias();
    }
}

?>
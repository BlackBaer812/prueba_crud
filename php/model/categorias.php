<?php

require_once __DIR__ . '/../common.php';

class categoriasModel extends commonFunctions{

    public static function getTodasCategorias(){
        $sql = "SELECT * FROM categoria";
        return self::database($sql);
    }

}

?>
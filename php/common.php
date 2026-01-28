<?php

class commonFunctions{
    protected static function database($sql, $data = []) {

        require __DIR__ . "/config/database.php";

        try {
            // Conectar a la base de datos con PDO
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
            $pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute($data);

            // Si la consulta es un SELECT, devuelve los resultados
            if (str_starts_with(strtoupper(trim($sql)), 'SELECT')) {
                return $stmt->fetchAll();
            }

            return $result ? true : false;
        } catch (PDOException $e) {
            return ["errorinfo" => $e -> errorInfo];
        }
    }
}

    

?>
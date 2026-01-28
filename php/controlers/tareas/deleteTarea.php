<?php

require_once "./tareas.php";

$response = tareasController::deleteTareaVuelta();

echo json_encode($response);

?>
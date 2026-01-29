<?php

require_once "./tareas.php";

$response = tareasController::completeTareaVuelta();

echo json_encode($response);

?>
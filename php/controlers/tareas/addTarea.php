<?php

require_once './tareas.php';
echo json_encode(tareasController::addTareaVuelta());

?>
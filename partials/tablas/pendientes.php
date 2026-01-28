<table class="table" id = "tablaTareasPendientes">
    <thead>
        <tr>
            <th class="text-center" scope="col">Nombre</th>
            <th class="text-center" scope="col">Categorias</th>
            <th class="text-center" scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        require_once "php/controlers/tareas/getTareas.php";
        foreach ($tareasPendientes as $tarea) : ?>
            <tr id="fila<?php echo $tarea['id']; ?>" class="filaPendiente" att_id="<?php echo $tarea['id']; ?>">
                <td class="text-center"><?php echo htmlspecialchars($tarea['nombre']); ?></td>
                <td class="text-center">
                    <?php 
                        foreach($tarea['categorias'] as $categoria){
                            echo '<span class="badge bg-primary me-1">' . htmlspecialchars($categoria['categoria_nombre']) . '</span>';
                        }
                    ?>
                </td>
                <td class="text-center">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-2 gap-2">
                            <button class="btn btn-sm btn-danger" id="eliminar<?php echo $tarea['id']; ?>" att_id="<?php echo $tarea['id']; ?>">Eliminar</button>
                            <button class="btn btn-sm btn-success" id="completar<?php echo $tarea['id']; ?>" att_id="<?php echo $tarea['id']; ?>">Completar</button>
                        </div>
                    </div>
                    
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
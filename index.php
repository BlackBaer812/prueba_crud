<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="Marcos Ruiz Clemente">
    <title>CRUD prueba</title>
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>
    <main class="container-fluid">
        
        <div class="row">
            <div class="col-2">
                <!-- Seccion menu lateral -->
            </div>
            <div class="col-10">
                <!-- Sección del formulario -->

                <section>
                    <div class="row">
                        <div class="col-12">
                            <form class="container" id="formNuevaTarea" action="">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" name="nombre" placeholder="Nueva tarea">
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <?php 
                                                require_once 'php/controlers/categorias/getCategorias.php';

                                                foreach($categorias as $categoria){
                                            ?>
                                            <div class="col">
                                                <input type="checkbox" id="categoria_<?php echo $categoria['id']; ?>" class="form-check-input" att_id= "<?php echo $categoria['id']; ?>">

                                                <label for="categoria_<?php echo $categoria['id']; ?>" class="form-check-label"><?php echo htmlspecialchars($categoria['nombre']); ?></label>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="submit" class="btn btn-success">Agregar Tarea</button>
                                    </div>
                                </div>
                            </form>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center align-items-center">
                                        <p id="mensajeForm"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección de botones para filtrar tareas -->
                <section>
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center mb-4 gap-3">
                            <button class="btn btn-primary">Tareas pendientes</button>
                            <button class="btn btn-primary">Tareas completadas</button>
                        </div>
                    </div>
                </section>

                <!-- Sección del listado de tareas pendientes -->
                <section>
                    <div class="row">
                        <div class="col-12">
                            <div class="container">
                                <?php 
                                    require_once "partials/tablas/pendientes.php";
                                ?>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Sección del listado de tareas completadas -->
                <section class="d-none">
                    <div class="row">
                        <div class="col-12">
                            <div class="container">
                                <?php 
                                    require_once "partials/tablas/completadas.php";
                                ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
    </main>

    <script type="module" src="js/custom.js"></script>
</body>
</html>
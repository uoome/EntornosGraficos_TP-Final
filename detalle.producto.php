<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");

include(DAO_PATH."dao.usuario.php");
include(DAO_PATH."dao.zapatilla.php");

// Iniciar/Retomar sesion
session_start();

// Fetch usuario
$usuarioActual = new Usuario(); // No se si es necesario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php") ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php") ?>

    <!-- Validar entrada de datos -->
    <?php 
        // Validar que se haya enviado ID
        if(isset($_GET['id'])) {
            // Guardar
            $id = $_GET['id'];
            // Service
            $zapatillaService = new ZapatillaDataService();
            // Buscar producto en la DB
            $existe = $zapatillaService->validarExistenciaDeZapatilla($id);
            // Si encontro el registro
            if ($existe) {
                // $data = new Zapatilla();
                $data = $zapatillaService->getZapatilla($id); 
                var_dump($data);
                // Si hay datos devueltos
                if($data != null) {
    ?>

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="index.php">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="tienda.php">
                    Tienda
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detalle Producto '<?php print($data->get_nombre()); ?>'
            </li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="container-fluid">

        <!-- Mensaje alerta -->
        <?php if ($usuarioActual == null) { ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                Debe loguarse para realizar compras
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <!-- Media del producto -->
        <div class="media">
            <!-- Imagen -->
            <img 
                src="<?= $data->get_img_path() ?>" 
                class="img-fluid w-50 mr-3" 
                alt="Imagen Zapatilla Modelo <?= $data->get_nombre() ?>"
            >
            <!-- Detalles -->
            <div class="media-body">
                <h1 class="mt-0">
                    <?php print($data->get_nombre()); ?>
                </h1>
                <p>
                    <?php if($data->get_precio() != null) { print('<b>$ ' . $data->get_precio() .'</b>'); } else { ?>
                    <b>$ 00.00</b>
                    <?php } ?>
                </p>
                <p>
                    <?php if($data->get_descripcion() != null ) print($data->get_descripcion()); ?>
                </p>
                <hr />
                <!-- Form -->
                <form action="Forms/manejo.carro.php" method="POST">
                    <div class="form-group">
                        <label for="colorSelect">Color</label>
                        <select class="form-control form-control-sm" id="colorSelect" name="colorSelect" required>
                            <option value="null" <?php if($data->get_color() == null) echo 'selected'?>>Seleccione color..</option>
                            <option value="Blanco" <?php if($data->get_color() == 'Blanco') echo 'selected'?>>Blanco</option>
                            <option value="Negro" <?php if($data->get_color() == 'Negro') echo 'selected'?>>Negro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="talleSelect">Talle</label>
                        <select class="form-control form-control-sm" id="talleSelect" name="talleSelect" required>
                            <option value="0" <?php if($data->get_talle() == 0) echo 'selected'?>>Seleccione talle..</option>
                            <option value="36" <?php if($data->get_talle() == 36) echo 'selected'?>>36</option>
                            <option value="37" <?php if($data->get_talle() == 37) echo 'selected'?>>37</option>
                            <option value="38" <?php if($data->get_talle() == 38) echo 'selected'?>>38</option>
                            <option value="39" <?php if($data->get_talle() == 39) echo 'selected'?>>39</option>
                            <option value="40" <?php if($data->get_talle() == 40) echo 'selected'?>>40</option>
                            <option value="41" <?php if($data->get_talle() == 41) echo 'selected'?>>41</option>
                            <option value="42" <?php if($data->get_talle() == 42) echo 'selected'?>>42</option>
                            <option value="43" <?php if($data->get_talle() == 43) echo 'selected'?>>43</option>
                            <option value="44" <?php if($data->get_talle() == 44) echo 'selected'?>>44</option>
                            <option value="45" <?php if($data->get_talle() == 45) echo 'selected'?>>45</option>
                        </select>
                    </div>
                    <div class="hidden">
                        <input type="hidden" name="idProd" value="<?= $id ?>">
                    </div>
                    <div class="form-row">
                        <div class="col col-sm-3">
                            <input type="number" name="inputCantidad" id="inputCantidad" class="form-control form-control" value="1">
                        </div>
                        <dov class="col col-sm-9">
                            <button 
                                role="submit" 
                                name="btnAddCarro" 
                                class="btn btn-info btn-block" 
                                alt="Agregar producto '<?= $data->get_nombre() ?>' al carro"
                                title="Agregar producto '<?= $data->get_nombre() ?>' al carro"
                                <?php if(is_null($usuarioActual)) echo "disabled" ?>
                            >
                                <i class="fas fa-cart-arrow-down"></i>
                            </button>
                        </dov>
                    </div>
                </form>
            </div>
        </div>

        <hr />

        <h3>Mas Detalles</h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, exercitationem nam corrupti ad vitae nulla dignissimos atque sit aut, quisquam officiis sint velit aperiam magnam consequatur, optio saepe esse vel?</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo, exercitationem nam corrupti ad vitae nulla dignissimos atque sit aut, quisquam officiis sint velit aperiam magnam consequatur, optio saepe esse vel?</p>

        <?php } } else { ?>
            <div class="alert alert-warning" role="alert">
                Lo sentimos, ha ocurrido un error al recuperar datos de la DB. Intente mas tarde.
            </div>            
        <?php } ?>

        <!-- Footer -->
        <?php include(INCLUDES_PATH."footer.html") ?>
    </div>

    <!-- Sin ID no hay contenido -->
    <?php } else { ?>

        <div class="alert alert-warning" role="alert">
            Lo sentimos, ha ocurrido un error. Intente mas tarde.
        </div>

    <?php } ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
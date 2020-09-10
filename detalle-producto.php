<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include_once(INCLUDES_PATH.'/db.php');
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
            // Buscar producto en la DB
            $existeZapaQuery = "SELECT * FROM `zapatilla` WHERE id_zapatilla = '$id';";
            $existentZapa = $conn->query($existeZapaQuery);
            // Si hay datos devueltos
            if ($existentZapa->num_rows == 1) {
                $data = $existentZapa->fetch_assoc();        
    ?>

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="inicio.php">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="tienda.php">
                    Tienda
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detalle Producto <?= $data['nombre'] ?>
            </li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="container-fluid">
        <!-- Media del producto -->
        <div class="media">
            <!-- Imagen -->
            <img 
                src="<?= $data['img_path'] ?>" 
                class="img-fluid w-50 mr-3" 
                alt="Imagen Zapatilla Modelo <?= $data['nombre'] ?>"
            >
            <!-- Detalles -->
            <div class="media-body">
                <h1 class="mt-0">
                    <?= $data['nombre'] ?>
                </h1>
                <p>
                    <?php if(isset($data['precio'])) echo '<b>$ ' . $data['precio'] .'</b>'; else { ?>    
                    <b>$ 00.00</b>
                    <?php } ?>
                </p>
                <p>Agregar detalle.</p>
                <hr />
                <form action="#" method="">
                    <div class="form-group">
                        <label for="colorSelect">Color</label>
                        <select class="form-control form-control-sm" id="colorSelect" required>
                            <option value="">Seleccione color..</option>
                            <option value="">Blanco</option>
                            <option value="">Negro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="talleSelect">Talle</label>
                        <select class="form-control form-control-sm" id="talleSelect" required>
                            <option value="">Seleccione talle..</option>
                            <option value="">Blanco</option>
                            <option value="">36</option>
                            <option value="">37</option>
                            <option value="">38</option>
                            <option value="">39</option>
                            <option value="">40</option>
                            <option value="">41</option>
                            <option value="">42</option>
                            <option value="">43</option>
                            <option value="">44</option>
                            <option value="">45</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="col col-sm-3">
                            <input type="text" name="" id="inputCantidad" class="form-control form-control" value="1">
                        </div>
                        <dov class="col col-sm-9">
                            <button role="button" name="btnAddCarro" class="btn btn-info btn-block" value="Comprar">
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

        <?php } else { ?>
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
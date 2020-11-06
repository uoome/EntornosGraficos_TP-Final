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

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Detalle Producto | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: darkcyan;">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-shoe-prints"></i>
            Tibbonzapas
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <!-- Icono menú hamburguesa -->
            <span class="fas fa-hamburger"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav fa-ul">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a class="nav-link" href="tienda.php">
                    <i class="fas fa-store"></i> Tienda
                </a>
                <a class="nav-link" href="contacto.php">
                    <i class="fas fa-phone-volume"></i> Contacto
                </a>
                <!-- Carro Compra | Usuario Loggeado -->
                <?php if ($usuarioActual != null) { ?>
                    <a class="nav-link" href="verCarro.php">
                        <i class="fas fa-cart-arrow-down"></i> Carro
                    </a> 
                    <a class="nav-link" href="historialCompras.php">
                        <i class="fas fa-receipt"></i> Compras
                    </a>
                        
                    <!-- Dropdown ABMs | Usuario Admin -->
                    <?php if ($usuarioActual->get_tipo() == UserTypeEnum::Administrator) { ?>
                    <ul class="navbar-nav ml-auto fa-ul">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-wrench"></i> ABMs
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="panel.usuarios.php">
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                            <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="panel.zapatillas.php">
                                    <i class="fas fa-shoe-prints"></i> Zapatillas
                                </a>
                            </div>
                        </li>
                    </ul>
                <?php } } ?>      
            </div>
            <!-- Seccion LogOut -->
            <div class="navbar-nav ml-auto fa-ul">
                <?php if ($usuarioActual != null) { ?>
                    <ul class="navbar-nav ml-auto fa-ul">
                        <li class="nav-item dropdown dropleft">
                            <a 
                                class="nav-link dropdown-toggle" 
                                href="#" 
                                id="navbarDropdownLogOutLink" 
                                role="button" 
                                data-toggle="dropdown" 
                                aria-haspopup="true" 
                                aria-expanded="false"
                            >
                                <i class="fas fa-user-circle"></i> <?= $usuarioActual->get_username() ?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownLogOutLink">
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-in-alt"></i> LogOut
                                </a>
                            </div>
                        </li>
                    </ul>
                <?php } else { ?>     
                    <a class="nav-link" href="login.php">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>       
                <?php } ?>      
            </div>
        </div>
    </nav>
    
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
                            <option value="null" selected>Seleccione color..</option>
                            <option value="Blanco">Blanco</option>
                            <option value="Negro" >Negro</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="talleSelect">Talle</label>
                        <select class="form-control form-control-sm" id="talleSelect" name="talleSelect" required>
                            <option value="0" selected>Seleccione talle..</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
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

    </div>
    <!-- Footer -->
    <?php include(INCLUDES_PATH."footer.html") ?>

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
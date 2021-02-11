<?php 
// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.usuario.php");
include_once(DATA_PATH . "data.compra.php");
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DATA_PATH . "data.lineaCompra.php");
include_once(DATA_PATH . "data.zapatilla.php");
include_once(DATA_PATH . "forma.pago.php");
include_once(DAO_PATH . "dao.compra.php");
include_once(DAO_PATH . "dao.lineaCompra.php");
include_once(DAO_PATH . "dao.carro.compra.php");
include_once(DAO_PATH . "dao.zapatilla.php");

// Si hay ID

if (isset($_GET['id'])) {
    // Guardar ID
    $id = $_GET['id'];

    // Fetch usuario sesion
    if (isset($_SESSION['usuarioActual'])) {
        $usuarioActual = $_SESSION['usuarioActual'];
        // Fetch datos compra
        $compraService = new CompraService();
        $compra = $compraService->getCompra($id);

        // Fetch datos carro compra
        $carroService = new CarroService();
        $carro = $carroService->getDatosCarro($compra->get_carro());

        // Fetch Lineas de Compra del carro
        $lineasService = new LineaCompraService();
        $lineasCarro = $lineasService->getLineasCarro($carro->get_id());
    } else $usuarioActual = null;
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
    //Redireccionar al form
    header("Location: historialCompras.php");
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Styles -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <!-- Custom CSS -->
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }
    </style>

    <title>Detalle Compra | Tibbonzapas</title>

</head>

<body class="bg-light">
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php") ?>
    
    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">
                    <a href="index.php">
                        Inicio
                    </a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="historialCompras.php">
                        Compras
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Detalle Compra '<?= $compra->get_id() ?>'
                </li>
            </ol>
        </nav>

    <!-- Contenido solo visible para usuarios logueados -->
    <?php if($usuarioActual != null) { ?>

    <main role="main" class="container">

        <div class="my-3 p-3 bg-white rounded shadow-sm heavy-rain-gradient color-block">
            <h5 class="border-bottom border-gray pb-2 mb-0">Detalle Compra: #<?= $compra->get_id() ?></h5>
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">Total:</strong>
                    $ <?php echo number_format( $compra->get_total(), 2, ',', '.'); ?>
                </p>
            </div>
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">Fecha Compra:</strong>
                    <?= $compra->get_fechaCompra() ?></p>
                </p>
            </div>
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">Direccion de entrega:</strong>
                    <?php 
                        $dir = $compra->get_direccionEntrega(); 
                        if(isset($dir)) echo $dir;
                        else echo "Retiro por local."; 
                    ?>
                </p>
            </div>
            <div class="media text-muted pt-3">
                <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <strong class="d-block text-gray-dark">Pago:</strong>
                    <?php 
                        switch($compra->get_tipoPago()){
                            case FormaPago::Efectivo: echo "Efectivo"; break;
                            case FormaPago::Debito: echo "Debito"; break;
                            case FormaPago::Credito: echo "Credito"; break;
                        }
                    ?>
                </p>
            </div>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0">Productos</h6>
            <?php 
                if(count($lineasCarro) > 0) { 
                // Inicializar servicio zapatilla
                    $zapatillaService = new ZapatillaDataService();
                    foreach($lineasCarro as $l) {
                    // Fetch zapatilla de linea
                        $z = $zapatillaService->getZapatilla($l->get_idZapatilla());         
            ?>
            <div class="media text-muted pt-3">
                <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32">
                    <title>Producto nro </title>
                    <rect width="100%" height="100%" fill="#007bff" />
                    <text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text>
                </svg>
                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <!-- Nombre, cantidad, precio unitario -->
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <strong class="text-gray-dark"><?= $z->get_nombre() ?></strong>
                        <span>
                            <i><?= $l->get_qty() ?>x</i>
                            $ <?php echo number_format($z->get_precio(), 2, ',', '.'); ?>
                        </span>
                    </div>
                    <!-- Descripcion y total linea -->
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span class="d-block">
                        <?php 
                            $desc = $z->get_descripcion();
                            if(isset($desc)) echo $desc;
                        ?>
                        </span>
                        <span><strong>$ <?php echo number_format($l->get_subtotalLinea(), 2, ',', '.'); ?></strong></span>
                    </div>
                    <!-- Color y talle -->
                    <span class="d-block"> 
                        <?php 
                            $color = $l->get_color();
                            if(isset($color)) echo "Color: ". $color . " - ";
                        ?>

                        <?php 
                            $talle = $l->get_talle();
                            if(isset($talle)) echo "Talle: ".$talle;
                        ?>
                    </span>
                </div>
            </div>
            <?php } } ?>
            <small class="d-block text-right mt-3">
                <a href="historialCompras.php">Volver</a>
            </small>
        </div>
    </main>
<!--     
    <div class="container-fluid">
        
    </div> -->

    <!-- Footer -->
    <?php include(INCLUDES_PATH . "footer.html") ?>

    <!-- Mensaje de autorizacion -->
    <?php } else { ?>
    <div class="container mt-3">
        <div class="alert alert-danger text-center" role="alert">
            No esta autorizado a estar en esta seccion!
        </div>
    </div>
    <?php } ?>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script>
        window.jQuery ||
            document.write(
                '<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>'
            );
    </script>
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script src="offcanvas.js"></script>

</body>

</html>
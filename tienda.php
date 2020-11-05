<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");

include(DAO_PATH . "dao.usuario.php");
include(DAO_PATH . "dao.zapatilla.php");

// Iniciar/Retomar sesion
session_start();

// Fetch usuario
$usuarioActual = new Usuario(); // No se si es necesario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

//Limito la busqueda de productos a mostrar por pagina
$TAMANIO_PAGINA = 4;

// Examino la página a mostrar y el inicio del registro a mostrar
if(isset($_GET['pagina'])) { 
    $pagina = $_GET['pagina']; // Recuperar pagina
    $inicio = ($pagina - 1) * $TAMANIO_PAGINA; // Calcular registros de la pagina actual
} else { 
    $pagina = 1; // 1ra pagina
    $inicio = 0; // 1ros registros
}

// Fecth zapatillas
$zapatillaService = new ZapatillaDataService();

// Fetch zapas
// Si hay POST y tiene criterio
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['criterioSelect'] != 'N') {
    $criterio = "WHERE tipo = '" . $_POST['criterioSelect'] ."'";
    $zapas = $zapatillaService->getTiendaZapatillasCriterio($criterio, $inicio, $TAMANIO_PAGINA);
    // Guardar cantidad de productos
    $cant_prod = count($zapas);
} else { // Sino, busqueda sin criterio
    // Guardar cantidad de productos
    $cant_prod = $zapatillaService->getTotalRegistrosZapas();
    $zapas = $zapatillaService->getTiendaZapatillas($inicio, $TAMANIO_PAGINA); 
}

// Calcular cantidad de paginas a formar (redondeadas hacia arriba)
$total_paginas  = ceil($cant_prod / $TAMANIO_PAGINA);
// echo "pagina: " . $pagina . " de " . $total_paginas . " paginas";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Tienda | Tibbonzapas</title>
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
        <div class="navbar-nav fa-ul">
            <a class="nav-link" href="index.php">
                <i class="fas fa-home"></i> Inicio
            </a>
            <a class="nav-link active" href="tienda.php">
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
    </nav>

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="index.php">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tienda</li>
        </ol>
    </nav>

    <!-- Content | Mostrar solo si hay zapatillas  -->
    <div class="container-fluid">

        <div class="container">
            <!-- Mensaje alerta -->
            <?php if ($usuarioActual == null) { ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Debe loguarse para realizar compras
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

            <h1 class="h2 text-center">Tienda Tibbonzapas</h1>
            <hr />
            <?php
            // Si hay datos
            if ($zapas != null) {
            ?>
                <!-- Row de 3 columnas -->
                <div class="row row-cols-2 row-cols-md-4 justify-content-around">
                    <!-- Columna izquierda -->
                    <div class="col">
                        <p>
                            Resultados: <i><?= count($zapas) ?></i>
                        </p>
                    </div>
                    <!-- Columna central-->
                    <div class="col">
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <!-- Boton buscar | Agregar filtros -->
                                    <button type="submit" class="btn btn-outline-secondary" name="btnBuscar" title="Buscar">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <select 
                                    class="custom-select" 
                                    id="selectFilter"
                                    name="criterioSelect" 
                                    aria-label="Selector de opciones de filtro"
                                >
                                    <option value="N">Elija...</option>
                                    <option value="H">Modelos Hombres</option>
                                    <option value="M">Modelos Mujeres</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- Columna Derecha -->
                    <?php if ($usuarioActual != null) { ?>
                        <div class="col text-right">
                            <a class="btn btn-outline ml-auto" href="verCarro.php" title="Ver carro de compras">
                                <i class="fas fa-cart-arrow-down"></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <!-- Cards de Productos -->
                <div class="row row-cols-2 row-cols-md-4">
                    <?php
                    foreach ($zapas as $zapa) {
                    ?>
                        <div class="col mb-4">
                            <div class="card h-100 bg-light">
                                <img src="<?= $zapa['img_path'] ?>" class="card-img-top" alt="Imagen modelo <?= $zapa['nombre'] ?>">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <?= $zapa['nombre'] ?>
                                    </h5>
                                    <p class="card-text">
                                        $ <?php empty($zapa['precio']) ? print("0") : print number_format($zapa['precio'], 2, ',', '.'); ?>  
                                    </p>
                                    <hr />
                                    <?php if ($usuarioActual == null) { ?>
                                        <a href="login.php" class="btn btn-success btn-block" title="Comprar Producto <?= $zapa['nombre'] ?>">
                                            <i class="fas fa-money-bill-wave"></i>
                                            Comprar
                                        </a>
                                        <a class="btn btn-info btn-block" href="login.php" title="Agregar producto <?= $zapa['nombre'] ?> al carro">
                                            <i class="fas fa-cart-arrow-down"></i>
                                            Agregar al carro
                                        </a>
                                    <?php } else { ?>
                                        <a href="detalle.producto.php?id=<?= $zapa["id_zapatilla"] ?>" class="btn btn-success btn-block" title="Comprar Producto <?= $zapa['nombre'] ?>">
                                            <i class="fas fa-money-bill-wave"></i>
                                            Comprar
                                        </a>
                                        <a class="btn btn-info btn-block" href="Forms/manejo.carro.php?action=addToCart&id=<?php echo $zapa["id_zapatilla"]; ?>&qty=1">
                                            <i class="fas fa-cart-arrow-down"></i>
                                            Add to cart
                                        </a>
                                    <?php }  ?>
                                </div>
                            </div>
                        </div>
                    <?php }  ?>
                </div>

                <!-- Paginación -->
                <div class="row justify-content-around mt-3">
                    <nav aria-label="Paginacion de tienda">
                        <ul class="pagination">
                            <!-- Deshabilitar el boton "Anterior" si es la primera pagina -->
                            <li class="page-item <?php echo $pagina <= 1 ? 'disabled' : '' ?>">
                                <a 
                                    class="page-link" 
                                    href="tienda.php?pagina=<?php echo $pagina - 1; ?>" 
                                    aria-label="Anterior"
                                >
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <!-- Imprimir cantidad de paginas dinamicamente -->
                            <?php for ($i = 0; $i < $total_paginas; $i++) { ?>
                                <li class="page-item <?php echo $pagina == $i+1 ? 'active' : '' ?>">
                                    <a class="page-link" href="tienda.php?pagina=<?= $i + 1 ?>">
                                        <?= $i + 1 ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <!-- Deshabilitar el boton "Siguiente" si es ultima pagina -->
                            <li class="page-item <?php echo $pagina >= $total_paginas ? 'disabled' : '' ?>">
                                <a 
                                    class="page-link" 
                                    href="tienda.php?pagina=<?php echo $pagina + 1; ?>" 
                                    aria-label="Siguiente"
                                >
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

        </div>

    <?php } else { ?>
        <div class="alert alert-warning" role="alert">
            Lo sentimos, ha ocurrido un error al recupera datos de la DB. Intente mas tarde.
        </div>
    <?php } ?>

    <!-- Footer -->
    <?php include(INCLUDES_PATH . "footer.html") ?>

    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>
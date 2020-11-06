<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.zapatilla.php");
include(DATA_PATH . "data.usuario.php");
// Iniciar sesion
session_start();

// Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
// Fetch datos de muestra
$zapaService = new ZapatillaDataService();
$muestra = $zapaService->getMuestra();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Index | Tibbonzapas</title>
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
            <!-- <span class="navbar-toggler-icon"></span> -->
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav fa-ul">
                <a class="nav-link active" href="index.php">
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

    <!-- Content -->
    <div class="container-fluid">
        <div class="container">
            <h1 class="text-center">Bienvenido a Tibbonzapas</h1>

            <!-- Carrusel -->
            <div id="carruselOfertas" class="carousel slide" data-ride="carousel">
                <!-- Rayas de indicación de slides -->
                <ol class="carousel-indicators">
                    <li data-target="#carruselOfertas" data-slide-to="0" class="active"></li>
                    <li data-target="#carruselOfertas" data-slide-to="1"></li>
                    <li data-target="#carruselOfertas" data-slide-to="2s"></li>
                </ol>

                <!-- Imágenes -->
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="img-fluid d-block w-100" src="IMG/Tibbon_Slide01.jpg" alt="Primer slide" />
                        <!-- Texto adicional -->
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Tibbonzapas</h5>
                            <p>Modernas 2020 !</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="img-fluid d-block w-100" src="IMG/Tibbon_Slide02.jpg" alt="Segunda slide" />
                        <!-- Texto adicional -->
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Tibbonzapas para hombres y mujeres</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img class="img-fluid d-block w-100" src="IMG/Tibbon_Slide03.jpg" alt="Tercer slide" />
                        <!-- Texto adicional -->
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Nuevos modelos</h5>
                            <p>Visite nuestra tienda para ver mas modelos.</p>
                        </div>
                    </div>
                </div>

                <!-- Flechas de avance y retroceso -->
                <a class="carousel-control-prev" href="#carruselOfertas" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carruselOfertas" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>

            <!-- Jumbotrom -->
            <div class="jumbotron">
                <div class="text-center">
                    <a class="btn btn-lg mb-1" href="#collapseData" data-toggle="collapse">
                        ¿Quiénes somos?
                    </a>
                </div>
                <div class="collapse text-justify" id="collapseData">
                    <p class="lead">
                        Tibbon es una marca rosarina que se inició en el 2013, mejorando
                        día a día la calidad de sus productos con tecnología e innovación
                        constantes. Es una empresa familiar, la cual apunta a la venta de
                        calzado unisex entre los 15 y los 35 años.
                    </p>
                    <p class="lead">
                        Diseñamos, fabricamos y comercializamos calzado, para brindar una
                        experiencia de comodidad, confort y estilo a tus pies. Lo que nos
                        importa es que estés a gusto con tus zapas y tengas ganas de
                        usarlas todos los días.
                    </p>
                    <p class="lead">
                        Queremos fomentar nuestro crecimiento a nivel nacional, por esa
                        misma razón desde principios del 2018 comenzamos con los envíos a
                        gran parte de nuestro país.
                    </p>
                    <hr class="my-4" />
                    <p>Para mas infomación visite nuestra página de contacto.</p>
                    <a class="btn btn-info" href="contacto.php" role="button">
                        <i class="far fa-question-circle"></i>
                        <span>Más info</span>
                    </a>
                </div>
            </div>

            <!-- Cards -->
            <?php if($muestra != null) { ?>
            <div class="card-deck">
                <?php foreach($muestra as $m) { ?>
                <div class="col-sm-6 col-md-3" style="width: 20px;">
                    <div class="card h-100 bg-light mb-1">
                        <img 
                            class="img-fluid d-block" 
                            src="<?= $m['img_path'] ?>" 
                            alt="Imagen modelo <?= $m['nombre'] ?>" 
                        />
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $m['nombre'] ?>
                            </h5>
                            <p class="card-text">
                            $ <?php empty($m['precio']) ? print("0") : print number_format($m['precio'], 2, ',', '.'); ?>   
                            </p>
                            <a 
                                href="detalle.producto.php?id=<?= $m["id_zapatilla"] ?>" 
                                class="btn btn-info btn-block"
                                title="Ver detalle modelo '<?= $m['nombre'] ?>'"
                            >
                                Detalle
                            </a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>

    </div>
    <!-- Footer -->
    <?php include(INCLUDES_PATH."footer.html") ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.zapatilla.php");
include(DATA_PATH . "data.usuario.php");
// Iniciar sesion
session_start();

$zapaService = new ZapatillaDataService();
$muestra = $zapaService->getMuestra();

?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php") ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php") ?>

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
                                $ <?php if(empty($m['precio'])) echo "0.0"; else echo $m['precio']; ?>
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

        <!-- Footer -->
        <?php include(INCLUDES_PATH."footer.html") ?>
    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
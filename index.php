<?php 
// Anterior
// include("includes/db.php"); 

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DB_PATH."db.php");
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
                            <p>Nuevos mdelos</p>
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
                    <a class="btn btn-info" href="contacto.html" role="button">
                        <i class="far fa-question-circle"></i>
                        <span>Más info</span>
                    </a>
                </div>
            </div>

            <!-- Cards -->
            <div class="card-deck">
                <div class="col-sm-6 col-md-3" style="width: 20px;">
                    <div class="card h-100 bg-light mb-1">
                        <img class="img-fluid d-block" src="IMG/Zapatilla_01.jpg" alt="Imagen producto" />
                        <div class="card-body">
                            <p class="card-text">$00.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3" style="width: 20px;">
                    <div class="card h-100 bg-light mb-1">
                        <img class="img-fluid d-block" src="IMG/Zapatilla_02.jpg" alt="Imagen producto" />
                        <div class="card-body">
                            <p class="card-text">$00.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3" style="width: 20px;">
                    <div class="card h-100 bg-light mb-1">
                        <img class="img-fluid d-block" src="IMG/Zapatilla_03.jpg" alt="Imagen producto" />
                        <div class="card-body">
                            <p class="card-text">$00.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3" style="width: 20px;">
                    <div class="card h-100 bg-light mb-1">
                        <img class="img-fluid d-block" src="IMG/Zapatilla_04.jpg" alt="Imagen producto" />
                        <div class="card-body">
                            <p class="card-text">$00.00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include(INCLUDES_PATH."footer.html") ?>
    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
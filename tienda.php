<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include_once(INCLUDES_PATH."db.php");
?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php") ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php") ?>

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="inicio.php">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tienda</li>
        </ol>
    </nav>

    <!-- Content | Mostrar solo si hay zapatillas  -->
    <div class="container-fluid">

        <div class="container">
            <h1 class="h2 text-center">Tienda Tibbonzapas</h1>
            <hr />
            <?php
                $sql = "SELECT * FROM zapatilla;";
                $result = $conn->query($sql);
                $cant = $result->num_rows;
                if ($cant > 0) {                    
            ?>
            <!-- Row de 2 columnas -->
            <div class="row row-cols-2 row-cols-md-4 justify-content-around">
                <!-- Columna izquierda -->
                <div class="col col-md-4">
                    <p>
                        Resultados: <i><?= $cant ?></i>
                    </p>
                </div>
                <!-- Columna derecha-->
                <div class="col col-md-4">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <!-- Boton buscar | Agregar filtros -->
                                <button class="btn btn-outline-secondary" type="button" name="btnBuscar" value="">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <select class="custom-select" id="selectFilter" aria-label="Selector de opciones de filtro">
                                <option value="">Elija...</option>
                                <option value="">Ofertas</option>
                                <option value="">Nuevos Modelos</option>
                                <option value="">Modelos Hombres</option>
                                <option value="">Modelos Mujeres</option>
                            </select>
                            </select>
                        </div>
                        <!-- 
                            <div class="form-group">
                            <label for="selectFilter">Filtrar por:</label>
                            <select class="form-control-sm" name="" id="selectFilter">
                            <option value="">-</option>
                            <option value="">Ofertas</option>
                            <option value="">Nuevos Modelos</option>
                            <option value="">Modelos Hombres</option>
                            <option value="">Modelos Mujeres</option>
                            </select>
                            </div> 
                        -->
                    </form>
                </div>
            </div>

            <!-- Cards de Productos -->
            <div class="row row-cols-2 row-cols-md-4">
                <?php
                    while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col mb-4">
                    <div class="card h-100 bg-light">
                        <img 
                            src="<?= $row['img_path'] ?>" 
                            class="card-img-top" 
                            alt="Imagen modelo <?= $row['nombre'] ?>"
                        >
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $row['nombre'] ?>
                            </h5>
                            <p class="card-text">
                                $ <?php if(empty($row['precio'])) echo "0.0"; else echo $row['precio']; ?>
                            </p>
                            <hr />
                            <a 
                                href="detalle-producto.php?id=<?= $row["id_zapatilla"] ?>" 
                                class="btn btn-success btn-block"
                                title="Comprar Producto <?= $row['nombre'] ?>"
                            >
                                <i class="fas fa-money-bill-wave"></i>
                                Comprar
                            </a>
                            <button role="button" name="btnAddCarro" class="btn btn-info btn-block" value="Comprar">
                                <i class="fas fa-cart-arrow-down"></i>
                                Agregar al carro
                            </button>
                        </div>
                    </div>
                </div>
                <?php }  ?>
            </div>

            <!-- Paginación -->
            <!-- Hay que automatizar el listado acorde a la cantidad de registros recibidos -->
            <div class="row justify-content-around mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#">Anterior</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
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
        <?php include(INCLUDES_PATH."footer.html") ?>

    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
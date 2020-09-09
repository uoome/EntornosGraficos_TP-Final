<?php include("includes/db.php") ?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include("includes/header.php") ?>

<body>
    <!-- NavBar -->
    <?php include("includes/navbar.php") ?>

    <!-- Migas de pan -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="inicio.html">Inicio</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Tienda</li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="container-fluid">

        <div class="container">
            <h1 class="h2 text-center">Tienda Tibbonzapas</h1>
            <hr />
            <!-- Row de 2 columnas -->
            <div class="row row-cols-2 row-cols-md-4 justify-content-around">
                <!-- Columna izquierda -->
                <div class="col col-md-4">
                    <p>Resultados: <i>nro</i> </p>
                </div>
                <!-- Columna derecha-->
                <div class="col col-md-4">
                    <form>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <!-- Boton buscar -->
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
            <!-- Hay que automatizar el listado con php o js -->
            <div class="row row-cols-2 row-cols-md-4">
                <div class="col mb-4">
                    <div class="card h-100 bg-light">
                        <img src="IMG/Zapatilla_01.jpg" class="card-img-top" alt="Imagen modelo Clasica Negro">
                        <div class="card-body">
                            <h5 class="card-title">Clasica Negro</h5>
                            <p class="card-text">$ 00.00</p>
                            <hr />
                            <a href="detalle-producto.php" class="btn btn-success btn-block">
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
                <div class="col mb-4">
                    <div class="card h-100 bg-light">
                        <img src="IMG/Zapatilla_02.jpg" class="card-img-top" alt="Imagen modelo Clasica Impress">
                        <div class="card-body">
                            <h5 class="card-title">Clasica Impress</h5>
                            <p class="card-text">$ 00.00</p>
                            <hr />
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-cart-arrow-down"></i>
                                Comprar
                            </a>
                            <button role="button" name="btnAddCarro" class="btn btn-info btn-block" value="Comprar">
                                <i class="fas fa-cart-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card h-100 bg-light">
                        <img src="IMG/Zapatilla_03.jpg" class="card-img-top" alt="Imagen modelo Mode">
                        <div class="card-body">
                            <h5 class="card-title">Mode</h5>
                            <p class="card-text">$ 00.00</p>
                            <hr />
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-cart-arrow-down"></i>
                                Comprar
                            </a>
                            <button role="button" name="btnAddCarro" class="btn btn-info btn-block" value="Comprar">
                                <i class="fas fa-cart-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col mb-4">
                    <div class="card h-100 bg-light">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paginación -->
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

        <!-- Footer -->
        <?php include("includes/footer.html") ?>

    </div>

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>
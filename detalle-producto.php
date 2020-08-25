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
                <a href="inicio.html">
                    Inicio
                </a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="tienda.html">
                    Tienda
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Detalle Producto x
            </li>
        </ol>
    </nav>

    <!-- Content -->
    <div class="container-fluid">
        <!-- Media del producto -->
        <div class="media">
            <!-- Imagen -->
            <img src="IMG/Zapatilla_01.jpg " class="img-fluid w-50 mr-3" alt="...">
            <!-- Detalles -->
            <div class="media-body">
                <h1 class="mt-0">Clasica Negro</h1>
                <p><b>$ 00.00</b></p>
                <p>Zapatilla Clásica en Negro ¡Tu estilo sos vos! ideal para los días de verano, color negro para hombres. Fabricadas en lona negra con goma blanca.</p>
                <hr />
                <form action="">
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


        <!-- Footer -->
        <?php include("includes/footer.html") ?>
    </div>

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>
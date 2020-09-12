<?php 
// Anterior
// include("includes/db.php");
// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(INCLUDES_PATH."db.php");  
?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php"); ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php"); ?>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado
    if (isset($_SESSION['usuarioActual'])) {
        $usuarioActual = $_SESSION['usuarioActual'];
        // Si el usuario es administrador
        if ($usuarioActual->get_tipo() == UserTypeEnum::Administrator) {

    ?>

    <div class="container mt-3">
        <!-- Mensaje alerta -->
        <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>

            <div class="jumbotron">
                <h3 class="mb-3">
                    <i class="fas fa-user-plus"></i>
                    Complete datos de registro
                </h3>
                <hr />
                <!-- Formulario -->
                <form action="Forms/admin-alta-zapatilla.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="inputNombre" class="col-md-2 col-form-label">Nombre/Modelo</label>
                        <div class="col-md-10">
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['modeloZapaErr'])) { ?>is-invalid<?php } ?>"  
                                id="inputNombre" 
                                name="nombreZapatilla"
                                aria-describedby="nombreHelpText" 
                                required 
                                autofocus
                            >
                            <?php if (isset($_SESSION['modeloZapaErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["modeloZapaErr"] ?></small>
                            <?php } else { ?>
                                <small id="nombreHelpText" class="form-text text-muted">Ej: Mamba.</small>
                            <?php } ?>                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputColor" class="col-md-2 col-form-label">Color</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="inputColor" name="colorZapatilla" aria-describedby="zapatillaHelpText">
                            <small id="zapatillaHelpText" class="form-text text-muted">
                                Ej: Rojo.
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPrecio" class="col-md-2 col-form-label">Precio</label>
                        <div class="col-md-10">
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['precioZapaErr'])) { ?>is-invalid<?php } ?>" 
                                id="inputPrecio" 
                                name="precioZapatilla" 
                                aria-describedby="precioHelpText"
                            >
                            <?php if (isset($_SESSION['precioZapaErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["precioZapaErr"] ?></small>
                            <?php } else { ?>
                                <small id="precioHelpText" class="form-text text-muted">
                                    Valor numerico sin el simbolo '$'.
                                </small>
                            <?php } ?>   
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputImagen" class="col-md-2 col-form-label">Cargue imagen</label>
                        <div class="col-md-10">
                            <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
                            <!-- <input type="hidden" name="MAX_FILE_SIZE" value="500000" /> -->
                            <input 
                                type="file" 
                                class="form-control-file <?php if (isset($_SESSION['imgErr'])) { ?>is-invalid<?php } ?>"  
                                id="inputImagen" 
                                name="fileZapa"
                                aria-describedby="imagenHelpText"
                            >
                            <?php if (isset($_SESSION['imgErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["imgErr"] ?></small>
                            <?php } else { ?>
                                <small id="imagenHelpText" class="form-text text-muted">
                                La imagen no debe pesar mas de 500kb. Debe tener un formato 'jpg', 'img', 'png'.
                                </small>
                            <?php } ?>    
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary" name="btnInsert">Agregar</button>
                        </div>
                    </div>
                </form>             
                <!-- Limpiar mensajes de error -->
                <?php 
                    unset($_SESSION['mensaje']); 
                    unset($_SESSION['modeloZapaErr']);
                    unset($_SESSION['precioZapaErr']);
                    unset($_SESSION['imgErr']);     
                ?>
            </div>  
    </div>

    <!-- Mensaje de autorizacion -->
    <?php } } else { ?>
    <div class="container mt-3">
        <div class="alert alert-danger text-center" role="alert">
            No esta autorizado a estar en esta seccion!
        </div>
    </div>
    <?php } ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php"); ?>

</body>

</html>
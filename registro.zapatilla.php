<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH . "db.php");
include(DATA_PATH . "data.usuario.php");

// Iniciar sesion
session_start();
// Fetch usuario
$usuarioActual = new Usuario();
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Registro de Zapatilla | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php"); ?>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado y es administrador
    if (
        $usuarioActual != null &&
        $usuarioActual->get_tipo() == UserTypeEnum::Administrator
    ) {
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
                <form action="Forms/admin.alta.zapatilla.php" method="POST" enctype="multipart/form-data">
                    <!-- Input Modelo -->
                    <div class="form-group row">
                        <label for="inputNombre" class="col-md-2 col-form-label">Nombre / Modelo</label>
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
                    <!-- Input Precio -->
                    <div class="form-group row">
                        <label for="inputPrecio" class="col-md-2 col-form-label">Precio <span class="text-muted">(opcional)</span></label>
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
                    <!-- Textarea -->
                    <div class="form-group row">
                        <label for="inputDescripcion" class="col-md-2 col-form-label">Descripcion <span class="text-muted">(opcional)</span></label>
                        <div class="col-md-10">
                            <textarea 
                                class="form-control" 
                                id="inputDescripcion" 
                                name="descripcionZapatilla" 
                                rows="3"
                                aria-describedby="descripHelpText"
                            ></textarea>
                            <small id="descripHelpText" class="form-text text-muted">
                                Ingrese una descripcion sobre el modelo.
                            </small>
                        </div>
                    </div>
                    <!-- Tipo -->
                    <div class="form-group row">
                        <label for="selectTipo" class="col-md-2 col-form-label">TIpo <span class="text-muted">(opcional)</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="selectTipo" name="selectTipo">
                                <option value="U" selected>Unisex</option>
                                <option value="H">Hombre</option>
                                <option value="M">Mujer</option>
                            </select>
                        </div>
                    </div>
                    <!-- Input IMG -->
                    <div class="form-group row">
                        <label for="inputImagen" class="col-md-2 col-form-label">Cargue imagen <span class="text-muted">(opcional)</span></label>
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
                    <!-- Submit -->
                    <div class="form-group row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary" name="insert_zapa">Agregar</button>
                        </div>
                    </div>
                </form>
                <!-- Limpiar mensajes de error -->
                <?php
                    if(isset($_SESSION['modeloZapaErr'])) unset($_SESSION['modeloZapaErr']);
                    if(isset($_SESSION['precioZapaErr'])) unset($_SESSION['precioZapaErr']);
                    if(isset($_SESSION['imgErr'])) unset($_SESSION['imgErr']);
                ?>
            </div>
        </div>

        <!-- Mensaje de autorizacion -->
    <?php } else { ?>
        <div class="container mt-3">
            <div class="alert alert-danger text-center" role="alert">
                No esta autorizado a estar en esta seccion!
            </div>
        </div>
    <?php } ?>

    <!-- Limpiar mensajes de sesion -->
    <?php 
        if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
        if(isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']);        
    ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php"); ?>

</body>

</html>
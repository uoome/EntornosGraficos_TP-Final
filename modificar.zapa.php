<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php"); // DB
include_once(DAO_PATH . "dao.usuario.php"); // Usuario service
include_once(DATA_PATH . "data.usuario.php"); // Usuario Data
include_once(DAO_PATH . "dao.zapatilla.php"); // Zapatilla service
include_once(DATA_PATH . "data.zapatilla.php"); // Zapatilla Data

// Si hay ID
if (isset($_GET['id'])) {
    // Guardar ID
    $id = $_GET['id'];

    // Iniciar/Retomar sesion
    session_start();

    // Fetch usuario sesion
    if (isset($_SESSION['usuarioActual'])) {
        $usuarioActual = $_SESSION['usuarioActual'];
        // Validar que existe el usuario
        $zapaService = new ZapatillaDataService();
        $zapatilla = $zapaService->getZapatilla($id);
    } else $usuarioActual = null;
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
    //Redireccionar al form
    // header("Location: panel.zapatillas.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <!-- Custom CSS -->
    <style>
        .container {
            padding: 20px;
        }

        input[type="number"] {
            width: 20%;
        }
    </style>
    <!-- JavaScript -->
    <script>
        function enableIMG(checkbox) {
            var imagFileInput = document.getElementById('inputImagen');

            if(checkbox.checked) {
                console.log("Habilitar cambio de imagen");
                imagFileInput.disabled = false;
            } else {
                console.log("Deshabilitar cambio de pass");
                imagFileInput.disabled = true;
            }
        }
    </script>

    <title>ABM Modificar Zapatilla | Tibbonzapas</title>
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
            <div class="col justify-content-around">

                <!-- Si hay zapatilla a modificar -->
                <?php if ($zapatilla != null) { ?>

                    <div class="jumbotron">
                <h3 class="mb-3">
                    <i class="fas fa-user-plus"></i>
                    Modificar Zapatilla
                </h3>
                <hr />
                <!-- Mensaje alerta -->
                <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
                <!-- Formulario -->
                <form action="Forms/admin.alta.zapatilla.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="idZapaToUpdate" value="<?= $id ?>">
                    <!-- Input Modelo -->
                    <div class="form-group row">
                        <label for="inputNombre" class="col-md-2 col-form-label">Nombre / Modelo</label>
                        <div class="col-md-10">
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['modeloZapaErr'])) { ?>is-invalid<?php } ?>" 
                                id="inputNombre" 
                                name="nombreZapatilla" 
                                value="<?= $zapatilla->get_nombre() ?>"
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
                                value="<?= $zapatilla->get_precio() ?>"
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
                            ><?= $zapatilla->get_descripcion() ?></textarea>
                            <small id="descripHelpText" class="form-text text-muted">
                                Ingrese una descripcion sobre el modelo.
                            </small>
                        </div>
                    </div>
                    <!-- Tipo -->
                    <div class="form-group row">
                        <label for="selectTipo" class="col-md-2 col-form-label">Tipo <span class="text-muted">(opcional)</span></label>
                        <div class="col-md-10">
                            <select class="form-control" id="selectTipo" name="selectTipo">
                                <option 
                                    value="U" 
                                    <?php if($zapatilla->get_sexo() == null) echo 'selected' ?>
                                >Unisex</option>
                                <option 
                                    value="H" 
                                    <?php if($zapatilla->get_sexo() == 'H') echo 'selected' ?>
                                >Hombre</option>
                                <option 
                                    value="M" 
                                    <?php if($zapatilla->get_sexo() == 'M') echo 'selected' ?>
                                >Mujer</option>
                            </select>
                        </div>
                    </div>
                    <!-- Input IMG -->
                    <div class="form-group row">
                        <label for="inputImagen" class="col-md-2 col-form-label">Cargue imagen</label>
                        <div class="col-md-6">
                            <!-- MAX_FILE_SIZE debe preceder al campo de entrada del fichero -->
                            <!-- <input type="hidden" name="MAX_FILE_SIZE" value="500000" /> -->
                            <input 
                                type="file" 
                                class="form-control-file <?php if (isset($_SESSION['imgErr'])) { ?>is-invalid<?php } ?>" 
                                id="inputImagen" 
                                name="fileZapa" 
                                aria-describedby="imagenHelpText"
                                disabled
                            >
                            <?php if (isset($_SESSION['imgErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["imgErr"] ?></small>
                            <?php } else { ?>
                                <small id="imagenHelpText" class="form-text text-muted">
                                    La imagen no debe pesar mas de 500kb. Debe tener un formato 'jpg', 'img', 'png'.
                                </small>
                            <?php } ?>
                        </div>
                        <div class="col-md-4 form-group form-check">
                            <input type="hidden" name="checkIMG" value="off" />
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="checkIMG" 
                                name="checkIMG" 
                                value="on"
                                onclick="enableIMG(this)"
                            >
                            <label class="form-check-label" for="checkIMG">Cambiar imagen</label>
                            <small id="checkIMGHelpText" class="form-text text-muted">
                                Checkear para cambiar imagen
                            </small>
                        </div>
                    </div>
                    <!-- Submit -->
                    <div class="form-group row">
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary" name="update_zapa">Modificar</button>
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

                    <!-- Si no hay zapatilla a modificar -->
                <?php } else {
                    $_SESSION['mensaje'] = "El registro a modificar no existe.";
                    $_SESSION['tipo_mensaje'] = "danger";
                    //Redireccionar al form
                    header("Location: panel.zapatillas.php");
                } ?>
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
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>
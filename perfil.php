<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DATA_PATH . "data.usuario.php");
// Iniciar sesion
session_start();

// Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <!-- JavaScript -->
    <script>
        function enablePasswordChange(checkbox) {
            var inputPass = document.getElementById('inputPass');
            var inputValPass = document.getElementById('inputValidarPass');

            if(checkbox.checked) {
                console.log("Habilitar cambio de pass");
                console.log(inputPass);
                console.log(inputValPass);
                inputPass.disabled = false;
                inputValPass.disabled = false;
            } else {
                console.log("Deshabilitar cambio de pass");
                inputPass.disabled = true;
                inputValPass.disabled = true;
            }
        }
    </script>

    <title>Perfil Usuario | Tibbonzapas </title>
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
                <a class="nav-link" href="index.php">
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
                                <a class="dropdown-item active" href="perfil.php">
                                    <i class="far fa-id-badge"></i> Perfil
                                </a>
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

    <!-- Content | Solo visible para usuario logueado -->
    <?php
    // Si hay usuario loggeado y  es Admin
    if ($usuarioActual != null) {
    ?>

    <!-- Content -->
    <div class="container mt-5">
        <div class="col justify-content-around">

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
                    <i class="far fa-user-circle"></i>
                    Datos Personales
                </h3>
                <hr />
                <!-- Formulario -->
                <form action="Forms/manejo.perfil.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Nombre</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['nombreErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputName" 
                                required 
                                autofocus
                                value="<?= $usuarioActual->get_nombre() ?>"  
                            />
                            <?php if (isset($_SESSION['nombreErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["nombreErr"] ?></small>
                            <?php } else { ?>
                                <small id="nombreHelp" class="form-text text-muted">Requerido. Ej: Nicolas.</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputApellido">Apellido</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['apeErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputApellido" 
                                required 
                                value="<?= $usuarioActual->get_apellido() ?>" 
                            />
                            <?php if (isset($_SESSION['apeErr'])) { ?>
                                <div class="invalid-feedback"><?= $_SESSION["apeErr"] ?></div>
                            <?php } else { ?>
                                <small id="apellidoHelp" class="form-text text-muted">Requerido. Ej: Gomez.</small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail">Email</label>
                            <input 
                                type="email" 
                                class="form-control <?php if (isset($_SESSION['emailErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputEmail"
                                required 
                                value="<?= $usuarioActual->get_email() ?>" 
                            />
                            <?php if (isset($_SESSION['emailErr'])) { ?>
                                <small class="invalid-feedback"><?= $_SESSION["emailErr"] ?></small>
                            <?php } else { ?>
                                <small id="emailHelp" class="form-text text-muted">Requerido. Ej: nicogomez@gmail.com</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputUser">Usuario</label>
                            <input 
                                type="text" 
                                class="form-control <?php if (isset($_SESSION['usernameErr'])) { ?>is-invalid<?php } ?>"
                                name="inputUser" 
                                required 
                                minlength="2" 
                                maxlength="10"
                                value="<?= $usuarioActual->get_username() ?>" 
                            />
                            <?php if (isset($_SESSION['usernameErr'])) { ?>
                                <div class="invalid-feedback"><?= $_SESSION["usernameErr"] ?></div>
                            <?php } else { ?>
                                <small id="usernameHelp" class="form-text text-muted">Entre 2 y 10 caracteres. Ej: NicoTibbon.</small>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-check">      
                        <input type="hidden" name="passCheck" value="off">                      
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            id="passCheck" 
                            name="passCheck" 
                            value="on"
                            onclick="enablePasswordChange(this)"
                        />
                        <label class="form-check-label" for="passCheck">
                            Cambiar contraseña
                        </label>
                        <small id="passChangeHelp" class="form-text text-muted">
                            Tildar si desea modificar la contraseña.
                        </small>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPass">Contraseña</label>
                            <input 
                                type="password" 
                                class="form-control <?php if (isset($_SESSION['passErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputPass" 
                                id="inputPass"
                                minlength="4" 
                                maxlength="10"
                                disabled  
                            />
                            <?php if (isset($_SESSION['passErr'])) { ?>
                                <div class="invalid-feedback"><?= $_SESSION["passErr"] ?></div>
                            <?php } else { ?>
                                <small id="passwordHelp" class="form-text text-muted">Entre 4 y 10 caracteres.</small>
                            <?php } ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputValidarPass">Validar contraseña</label>
                            <input 
                                type="password" 
                                class="form-control <?php if (isset($_SESSION['validarPassErr'])) { ?>is-invalid<?php } ?>" 
                                name="inputValidarPass"  
                                id="inputValidarPass"
                                minlength="4" 
                                maxlength="10" 
                                disabled
                            />
                            <?php if (isset($_SESSION['validarPassErr'])) { ?>
                                <div class="invalid-feedback"><?= $_SESSION["validarPassErr"] ?></div>
                            <?php } else { ?>
                                <small id="validarPassHelp" class="form-text text-muted">
                                    Debe ser igual a la contraseña ingresada.
                                </small>
                            <?php } ?>    
                        </div>
                    </div>
                    <button type="submit" name="save_perfil" class="mx-auto col-md-4 btn btn btn-info btn-block" >
                        <i class="far fa-check-circle"></i>
                        Guardar
                    </button>  
                </form>

                <!-- Limpiar mensajes -->
                <?php 
                    if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
                    if(isset($_SESSION['nombreErr'])) unset($_SESSION['nombreErr']); 
                    if(isset($_SESSION['apeErr'])) unset($_SESSION['apeErr']); 
                    if(isset($_SESSION['emailErr'])) unset($_SESSION['emailErr']); 
                    if(isset($_SESSION['usernameErr'])) unset($_SESSION['usernameErr']); 
                    if(isset($_SESSION['passErr'])) unset($_SESSION['passErr']); 
                    if(isset($_SESSION['validarPassErr'])) unset($_SESSION['validarPassErr']); 
                ?>

            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include(INCLUDES_PATH . "footer.html") ?>

    <!-- Mensaje de autorizacion -->
    <?php } else { ?>
    <div class="container mt-3">
        <div class="alert alert-danger text-center" role="alert">
            No esta autorizado a estar en esta seccion!
        </div>
    </div>
    <?php } ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>
    
</body>
</html>
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(DATA_PATH."data.usuario.php"); // Necesario para que no crashee el navbar

// Iniciar/Retomar sesion
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

    <title>Contacto | Tibbonzapas</title>
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
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="navbar-nav fa-ul">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i> Inicio
                </a>
                <a class="nav-link" href="tienda.php">
                    <i class="fas fa-store"></i> Tienda
                </a>
                <a class="nav-link active" href="tienda.php">
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
    <div class="container-fuild">

        <div class="container mt-2 shadow p-3 mb-5 bg-white rounded">
            <div class="card bg-light">
                <div class="card-header">
                    <img src="IMG/Tibbon_locacion.png" class="card-img-top mx-auto d-block" alt="Ubicación en mapa">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Contactenos</h5>
                    <!-- Mensaje alerta -->
                    <?php if (isset($_SESSION['mensaje'])) { ?>
                        <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                            <?= $_SESSION['mensaje'] ?>
                        </div>
                    <?php } ?>
                    <form action="Forms/manejo.contacto.php" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="nombre_contacto" placeholder="Nombre" required />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="email_contacto" placeholder="E-mail" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="coment_contacto" placeholder="Comentario" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="send_contacto" class="btn btn-success btn-block">
                                <i class="fas fa-envelope-square"></i>
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Limpiar mensajes -->
        <?php if (isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); ?>

    </div>
    <!-- Footer -->
    <?php include(INCLUDES_PATH."footer.html") ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
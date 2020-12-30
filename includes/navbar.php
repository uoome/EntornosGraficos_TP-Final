<?php
// // Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

?>

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
            <a class="nav-link active" href="index.php">
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
            <?php }
            } ?>
        </div>
        <!-- Seccion LogOut -->
        <div class="navbar-nav ml-auto fa-ul">
            <?php if ($usuarioActual != null) { ?>
                <ul class="navbar-nav ml-auto fa-ul">
                    <li class="nav-item dropdown dropleft">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLogOutLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle"></i> <?= $usuarioActual->get_username() ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownLogOutLink">
                            <a class="dropdown-item" href="perfil.php">
                                Perfil
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
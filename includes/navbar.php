<?php
// Fetch usuario
$usuarioActual = new Usuario(); // No se si es necesario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

?>

<!-- Barra nav -->
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
        <ul class="navbar-nav mr-auto fa-ul">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i>
                    Inicio
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tienda.php">
                    <i class="fas fa-store"></i>
                    Tienda
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contacto.php">
                    <i class="fas fa-phone-volume"></i>
                    Contacto
                </a>
            </li>
            <!-- Icono Login -->
            <?php if ($usuarioActual == null) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                </li>
            <?php } ?>

            <!-- Carro Compra | Usuario Loggeado -->
            <?php if ($usuarioActual != null) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="verCarro.php">
                        <i class="fas fa-cart-arrow-down"></i>
                        Carro
                    </a>
                </li>
                <!-- Dropdown ABMs | Usuario Admin -->
                <?php if ($usuarioActual->get_tipo() == UserTypeEnum::Administrator) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-wrench"></i>
                        ABMs
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="panel.usuarios.php">
                            <i class="fas fa-users"></i>
                            Usuarios
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="panel.zapatillas.php">
                            <i class="fas fa-shoe-prints"></i>
                            Zapatillas
                        </a>
                    </div>
                </li>
            <?php } } ?>

        </ul>

        <!-- Seccion LogOut -->
        <?php if ($usuarioActual != null) { ?>
            <ul class="navbar-nav ml-auto fa-ul">
                <li class="nav-item dropdown dropleft">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownLogOutLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user-circle"></i>
                        <?= $usuarioActual->get_username() ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownLogOutLink">
                        <a class="dropdown-item" href="logout.php">
                            <i class="fas fa-sign-in-alt"></i>
                            LogOut
                        </a>
                    </div>
                </li>
            </ul>
        <?php } ?>
    </div>
</nav>
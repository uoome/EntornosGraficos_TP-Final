<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.usuario.php");

// Iniciar/Retomar sesion
session_start();
// Fetch usuario
$usuarioActual = new Usuario();
if(isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Panel de Usuarios | Tibbonzapas</title>
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
                        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-wrench"></i> ABMs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item active" href="panel.usuarios.php">
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
    </nav>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado y  es Admin
    if (
        $usuarioActual != null && 
        $usuarioActual->get_tipo() == UserTypeEnum::Administrator
    ) {
    ?>
    

    <div class="container mt-3">
        <div class="card bg-light">
            <!-- Card Header -->
            <div class="card-header">
                <i class="fas fa-table"></i>
                Gestion de Usuarios
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!-- Mensaje alerta -->
                <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php } ?>
                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Acciones</th>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Traer usuarios
                        $usuarioService = new UsuarioService();
                        $data = $usuarioService->getUsuarios();
                        // var_dump($data);
                        // Si hay datos
                        if ($data != null) {
                            foreach($data as $user) {
                        ?>
                            <tr>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a 
                                            href="modificar.usuario.php?id=<?= $user["id_usuario"] ?>" 
                                            class="btn btn-info" 
                                            title="Modificar Usuario"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a 
                                            href="Forms/admin.delete.usuario.php?id=<?= $user["id_usuario"] ?>" 
                                            class="btn btn-danger" 
                                            title="Eliminar Usuario"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                <td><?= $user["id_usuario"] ?></td>
                                <td><?= $user["nombre"] ?></td>
                                <td><?= $user["apellido"] ?></td>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["telefono"] ?></td>
                                <td>
                                    <?php
                                    switch ($user["tipo_usuario"]) {
                                        case UserTypeEnum::Administrator:
                                            echo "Administrador";
                                            break;
                                        case UserTypeEnum::Client;
                                            echo "Cliente";
                                            break;
                                        default:
                                            echo "-";
                                            break;
                                    }
                                    ?>
                                </td>
                            </tr>

                        <?php } } else { ?>

                        <div class="alert alert-warning text-center" role="alert">
                            No se encontraron datos.
                        </div>
                        <?php } ?>

                        </tbody>
                    </table>

                    <!-- Limpiar mensajes de sesion -->
                    <?php 
                    unset($_SESSION['mensaje']); 
                    unset($_SESSION['tipo_mensaje']); 
                    ?>
                    
                </div>
            </div>        
            <!-- Card-Footer -->
            <div class="card-footer">
                <a 
                    href="registro.administrador.php" 
                    class="btn btn-primary" 
                    title="Crear Usuario"
                >
                    <i class="fas fa-plus"></i>
                </a>
            </div>
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

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>
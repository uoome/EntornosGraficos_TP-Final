<?php 
// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.usuario.php");
include_once(DATA_PATH . "data.compra.php");
include_once(DATA_PATH . "forma.pago.php");
include_once(DAO_PATH . "dao.compra.php");

// Iniciar/Retomar sesion
session_start();

// Fetch usuario
$usuarioActual = new Usuario(); // No se si es necesario
if (isset($_SESSION['usuarioActual'])) { 
    $usuarioActual = $_SESSION['usuarioActual'];
    // Si hay usuario, iniciar/traer carro
    $compraService = new CompraService();
    $comprasUsuario = $compraService->getComprasUsuario($usuarioActual->get_id());
    // var_dump($comprasUsuario);
} else $usuarioActual = null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>
    
    <title>Historial Compras | Tibbonzapas</title>
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
                <a class="nav-link" href="contacto.php">
                    <i class="fas fa-phone-volume"></i> Contacto
                </a>
                <!-- Carro Compra | Usuario Loggeado -->
                <?php if ($usuarioActual != null) { ?>
                    <a class="nav-link" href="verCarro.php">
                        <i class="fas fa-cart-arrow-down"></i> Carro
                    </a> 
                    <a class="nav-link active" href="historialCompras.php">
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

    <!-- Contenido solo visible para usuarios logueados -->
    <?php if($usuarioActual != null) { ?>
    <div class="container mt-3">
        <h1>Historial Compras</h1>
        <hr/>
        <!-- Mensaje alerta -->
        <?php if (isset($_SESSION['mensaje'])) { ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['mensaje'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <table class="table table-responsive-sm table-striped table-hover text-center">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Total</th>
                    <th scope="col" class="text-center">Fecha</th>
                    <th scope="col" class="text-center">Tipo Pago</th>
                    <th scope="col" class="text-center">Detalle</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if($comprasUsuario != null) {
                    foreach($comprasUsuario as $com) { ?>
                <tr>
                    <td class="table-primary"><?= $com['id_compra'] ?></td>
                    <td class="table-info">$
                        <?php echo number_format($com['total'], 2, ',', '.'); ?>
                    </td>
                    <td class="text-center"><?= $com['fecha_compra'] ?></td>
                    <td class="text-center">
                        <?php 
                            switch($com['tipo_pago']){
                                case FormaPago::Efectivo: echo "Efectivo"; break;
                                case FormaPago::Debito: echo "Debito"; break;
                                case FormaPago::Credito: echo "Credito"; break;
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <a 
                            href="detalleCompra.php?id=<?= $com['id_compra'] ?>" 
                            class="btn btn-outline-warning"
                            
                            title="Detalle Compra ID <?= $com['id_compra'] ?>"
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan="5">
                            <p>No tiene compras realizadas.</p>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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

    <!-- Limpiar mensajes de sesion -->
    <?php 
        unset($_SESSION['mensaje']); 
        unset($_SESSION['tipo_mensaje']); 
    ?>    

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>
</body>
</html>
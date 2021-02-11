<?php
/*
Esta página obtiene el contenido del carro y muestra sus artículos con el precio total. 
Además, el usuario podrá agregar más elementos al carro mediante el botón Continue Shopping o finalizarlo mediante el botón Checkout. Este último botón redirige al usuario a la página checkout.php donde el usuario tendrá una vista previa del pedido.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DATA_PATH . "data.lineaCompra.php");

// Iniciar/Retomar sesion
// session_start();

// Fetch usuario
$usuarioActual = new Usuario(); // No se si es necesario
if (isset($_SESSION['usuarioActual'])) { 
    $usuarioActual = $_SESSION['usuarioActual'];
    // Si hay usuario, iniciar/traer carro
    $carro = new CarroCompra();
    // var_dump($carro);
} else $usuarioActual = null;

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>
    
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
        function updateCartItem(qty, id) {
            console.log("Update:", qty, id);
            $.get(
                "Forms/manejo.carro.php", 
                { action:"updateCartItem", id:id, qty:qty }, 
                reponse => {
                    console.log(reponse);
                    if (reponse == 'ok') {
                        console.log("reload");
                        location.reload();
                    } else {
                        alert('Cart update failed, please try again.');
                    }
                }
            );
        }
    </script>
    <title>Carro de Compra | Tibbonzapas</title>
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


    <!-- Contenido solo visible para usuarios logueados -->
    <?php if($usuarioActual != null) { ?>
    <div class="container-fluid">
        <div class="container">
            <h2>Carro de Compra</h2>
            <!-- Mensaje alerta -->
            <?php if (isset($_SESSION['mensaje'])) { ?>
                <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                    <?= $_SESSION['mensaje'] ?>
                </div>
            <?php } ?>
            <!-- Table -->
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Subtotal</th>
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($carro->total_items() > 0) {
                        //get cart items from session
                        $cartItems = $carro->getContenidoCarro();
                        foreach ($cartItems as $key => $linea) {
                            if ($linea instanceof LineaCompra) {
                                $item = $linea->get_zapatilla();
                                // var_dump($key);
                                // var_dump($linea);
                                // var_dump($item);
                    ?>
                                <tr>
                                    <td><?= $item->get_nombre() ?></td>
                                    <td>$ 
                                        <?php 
                                            $item->get_precio() != null ? 
                                            print number_format($item->get_precio(), 2, ',', '.') : print("0"); 
                                        ?>
                                    </td>
                                    <td>
                                        <input 
                                            type="number" 
                                            class="form-control" 
                                            value="<?= $linea->get_qty() ?>" 
                                            onchange="updateCartItem(this.value,'<?= $key ?>')"
                                        >
                                    </td>
                                    <td>$ 
                                        <?php echo number_format($linea->get_subtotalLinea(), 2, ',', '.'); ?></td>
                                    <td class="text-center">
                                        <a href="Forms/manejo.carro.php?action=removeCartItem&id=<?= $key ?>" class="btn btn-danger" onclick="return confirm('Esta seguro que desea eliminar el item seleccionado?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php }
                        }
                    } else { ?>
                        <tr>
                            <td colspan="5">
                                <p>Tu carro esta vacio...</p>
                            </td>
                        </tr>
                        <?php } ?>
                </tbody>
            </table>
            <div class="row">
                <div class="col col-md-4">
                    <a href="tienda.php" class="btn btn-info btn-block">
                        <i class="fas fa-angle-left"></i> Tienda
                    </a>
                </div>
                <?php if ($carro->total_items() > 0) { ?>
                    <div class="col col-sm-4 text-center alert alert-warning" role="alert">
                        <strong>Total: $ <?php echo number_format($carro->total(), 2, ',', '.'); ?></strong>
                    </div>
                    <div class="col col-sm-4">
                        <a href="checkout.php" class="btn btn-success btn-block">
                            Comprar <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
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
    <!-- Custom pq hubo que quitar el "jquery.slim" que venia de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <!-- Fon Awesome JS -->
    <script defer src="CSS/fontawesome-free-5.14.0-web/js/all.js"></script>
</body>

</html>
<?php
/*
En este página, se registra el ID del cliente en la sesión y se obtienen los respectivos datos del cliente de la tabla customers. 
Una vez que el cliente decide realizar el pedido, llamamos al archivo cartAction.php con la solicitud “placeOrder”.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.usuario.php");
include_once(DATA_PATH . "data.lineaCompra.php");
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DAO_PATH . "dao.usuario.php");

session_start();

// Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

// Fetch carro 
$carro = new CarroCompra();
// redirect to home if cart is empty
if ($carro->total_items() <= 0) header("Location: index.php");

// set customer ID in session
$_SESSION['sessCustomerID'] = $usuarioActual->get_id();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Checkout | Tibbonzapas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <!-- CSS -->
    <style>
        .right {
            float: right;
        }
    </style>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php") ?>

    <!-- Contenido solo visible para usuarios logueados -->
    <?php if($usuarioActual != null) { ?>
    <div class="container-fluid">
        <!-- Preview -->
        <div class="container mt-2">
            <!-- Card -->
            <div class="card">
                <div class="card-header">
                    <p class="h2">Order Preview</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Col Left -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Arriba -->
                                <div class="col">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Precio</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($cart->total_items() > 0) {
                                                // echo "Cart";
                                                // var_dump($cart);
                                                //get cart items from session
                                                // echo "Cart Items";
                                                $cartItems = $cart->contents();
                                                // var_dump($cartItems);
                                                foreach ($cartItems as $item) {
                                                    $zapa = $item->get_zapatilla();
                                            ?>
                                                    <tr>
                                                        <td><?php echo $zapa->get_nombre(); ?></td>
                                                        <td><?php echo '$' . $zapa->get_precio(); ?></td>
                                                        <td><?php echo $item->get_qty(); ?></td>
                                                        <td><?php echo '$' . $item->get_subtotalLinea(); ?></td>
                                                    </tr>
                                                <?php }
                                            } else { ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <p>No hay items en tu carro....</p>
                                                    </td>
                                                <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Force next columns to break to new line -->
                                <div class="w-100"></div>
                                <!-- Abajo -->
                                <div class="col">
                                    <?php if ($cart->total_items() > 0) { ?>
                                        <div class="alert alert-secondary text-center ml-auto" role="alert">
                                            <strong>Total <?php echo '$' . $cart->total(); ?></strong>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <!-- Col right -->
                        <div class="col-md-4">
                            <h4>Detalles de envio</h4>
                            <?php if ($usuarioActual != null) { ?>
                                <p>
                                    <strong>Nombre: </strong><?php echo $usuarioActual->get_nombre(); ?>
                                </p>
                                <p>
                                    <strong>Apellido: </strong><?php echo $usuarioActual->get_apellido(); ?>
                                </p>
                                <p>
                                    <strong>Telefono: </strong><?php echo $usuarioActual->get_telefono(); ?>
                                </p>
                                <p>
                                    <strong>Email: </strong><?php echo $usuarioActual->get_email(); ?>
                                </p>
                            <?php } else { ?>
                                <p> Error al cargar datos del usuario </p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row justify-content-around">
                        <div class="col-4">
                            <a href="tienda.php" class="btn btn-info btn-block">
                                <i class="fas fa-angle-left"></i>
                                Continue Shopping
                            </a>
                        </div>
                        <div class="col-4">
                            <a href="Forms/cartAction.php?action=placeOrder" class="btn btn-success btn-block">
                                Place Order
                                <i class="fas fa-check"></i>
                            </a>
                        </div>
                    </div>
                </div>
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
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>
<?php
/*
Esta página obtiene el contenido del carrito y muestra sus artículos con el precio total. 
Además, el usuario podrá agregar más elementos al carrito mediante el botón Continue Shopping o finalizarlo mediante el botón Checkout. Este último botón redirige al usuario a la página checkout.php donde el usuario tendrá una vista previa del pedido.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DATA_PATH . "data.lineaCompra.php");

// Iniciar/Retomar sesion
// session_start();

// include 'Cart.php';
$carro = new CarroCompra();
var_dump($carro);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>View Cart - PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">

    <style>
        .container {
            padding: 20px;
        }

        input[type="number"] {
            width: 20%;
        }
    </style>
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
                });
            }
    </script>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php") ?>

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
                                    <td>$ <?php $item->get_precio() != null ? print $item->get_precio() : print("0"); ?>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" value="<?= $linea->get_qty() ?>" onchange="updateCartItem(this.value,'<?= $key ?>')">
                                    </td>
                                    <td>$ <?= $linea->get_subtotalLinea() ?></td>
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
                        <?php } ?>
                        </tr>
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
                        <strong>Total: $ <?= $carro->total() ?></strong>
                    </div>
                    <div class="col col-sm-4">
                        <a href="checkout.php" class="btn btn-success btn-block">
                            Checkout <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- Footer -->
        <?php include(INCLUDES_PATH . "footer.html") ?>
    </div>

    <!-- Scripts -->
    <!-- Custom pq hubo que quitar el "jquery.slim" que venia de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

    <!-- Fon Awesome JS -->
    <script defer src="CSS/fontawesome-free-5.14.0-web/js/all.js"></script>
</body>

</html>